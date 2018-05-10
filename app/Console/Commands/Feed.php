<?php

namespace App\Console\Commands;

use App\Category;
use App\Feed\FeedConstant;
use App\Feed\FeedLogger;
use App\Feed\FeedReader;
use App\Feed\Utility\ConvertToDateTime;
use App\Feed\Utility\ExtractUrls;
use App\FeedSource;
use Illuminate\Console\Command;

class Feed extends Command
{
    use ExtractUrls, ConvertToDateTime;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed {urls}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read feeds from given urls';

    private $feedLogger;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->feedLogger = new FeedLogger();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $urls = $this->argument('urls');
        $urlArr = $this->extractUrls($urls);

        $feed = new FeedReader($urlArr);
        $feed->init();

        $feedItems = $feed->getItems();

        $sources = [];
        $categories = [];

        foreach ($feedItems as $item) {
            $title = $item->get_title();
            $link = $item->get_permalink();

            if (is_null($title) || is_null($link)) {
                continue;
            }

            $sourceUrl = $item->get_base();
            if (!array_key_exists($sourceUrl, $sources)) {
                $source = FeedSource::where('link', $sourceUrl)->first();
                if (is_null($source)) {
                    $source = FeedSource::create(
                        [
                            'name' => $sourceUrl,
                            'link' => $sourceUrl,
                            'created_at' => new \DateTime(),
                        ]
                    );
                }
                $sources[$sourceUrl] = $source;
            }

            $categoryName = is_null($item->get_category()) ? FeedConstant::DEFAULT_CATEGORY : $item->get_category()->get_label();
            if (!array_key_exists($categoryName, $categories)) {
                $category = Category::where('name', $categoryName)->first();
                if (is_null($category)) {
                    $category = Category::create(
                        [
                            'name' => $categoryName,
                            'created_at' => new \DateTime(),
                        ]
                    );
                }
                $categories[$categoryName] = $category;
            }

            $source = $sources[$sourceUrl];
            $category = $categories[$categoryName];

            $content = strip_tags($item->get_description());
            $description = str_limit($content, $limit = 150, $end = '...');

            $publishedAt = $item->get_date('Y-m-d H:i:s');
            if (is_int($publishedAt)) {
                $publishedAt = $this->timestampToDateTime($publishedAt);
            }

            if (is_null($publishedAt)) {
                $publishedAt = new \DateTime();
            }

            $feed = new \App\Feed();
            $feed->title = $title;
            $feed->content = $content;
            $feed->description = $description;
            $feed->link = $link;
            $feed->published_at = $publishedAt;
            $feed->category()->associate($category);
            $feed->source()->associate($source);
            $feed->save();


            $message = !is_null($feed) ? "Feed: $title | $link." : "Failed to add feed: $title | $link.";
            $this->log($message);
        }

        $this->log("Finished.");
        $this->log("========================================");

        return;
    }

    private function log($message)
    {
        $this->line($message);
        $this->feedLogger->log($message);
    }
}
