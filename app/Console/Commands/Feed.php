<?php

namespace App\Console\Commands;

use App\Feed\FeedLogger;
use App\Feed\Processor\FeedProcessor;
use App\Feed\Processor\VNExpressFeedProcessor;
use App\Feed\Utility\ExtractUrls;
use Illuminate\Console\Command;
use Feed as FeedReader;

class Feed extends Command
{
    use ExtractUrls;
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

    /**
     * @var FeedLogger
     */
    private $feedLogger;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        FeedReader::$cacheDir = storage_path() . '/feeds/cache';
        FeedReader::$cacheExpire = '12 hours';
        $this->feedLogger = new FeedLogger();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \FeedException
     */
    public function handle()
    {
        $urls = $this->argument('urls');
        $urlArr = $this->extractUrls($urls);

        foreach ($urlArr as $url) {
            $feed = FeedReader::loadRss($url);
            $feedProcessor = $this->getFeedProcessor($url);
            foreach ($feed->item as $item) {
                $message = $feedProcessor->process($item, $url);
                $this->log($message);
            }
        }

        $this->log("Finished.");
        $this->log("========================================");

        return;
    }

    /**
     * @param string $url
     * @return FeedProcessor
     */
    public function getFeedProcessor(string $url): FeedProcessor
    {
        $host = parse_url($url, PHP_URL_HOST);
        switch($host) {
            case 'vnexpress.net':
                return new VNExpressFeedProcessor();
            default:
                return new FeedProcessor();
        }
    }

    private function log($message)
    {
        $this->line($message);
        $this->feedLogger->log($message);
    }
}
