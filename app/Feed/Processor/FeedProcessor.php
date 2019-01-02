<?php

namespace App\Feed\Processor;

use App\Category;
use App\Feed;
use App\Feed\FeedConstant;
use App\Feed\Utility\ConvertToDateTime;
use App\FeedSource;

class FeedProcessor
{
    use ConvertToDateTime;
    /**
     * @var array
     */
    protected $sources = [];

    /**
     * @var array
     */
    protected $categories = [];

    public function process(\SimpleXMLElement $item, string $url)
    {
        $title = $item->title;
        $link = $item->link;

        if (is_null($title) || is_null($link)) {
            return;
        }

        if (!array_key_exists($url, $this->sources)) {
            $this->sources[$url] = $this->getSource($url);
        }

        $categoryName = $this->extractCategoryName($item);
        if (!array_key_exists($categoryName, $this->categories)) {
            $this->categories[$categoryName] = $this->getCategory($categoryName);
        }

        $content = $item->{'content:encoded'};
        $description = $item->description;
        $source = $this->sources[$url];
        $category = $this->categories[$categoryName];
        $publishedAt = $this->timestampToDateTime(intval($item->timestamp));

        if (is_null($publishedAt)) {
            $publishedAt = new \DateTime();
        }

        $feed = $this->saveFeed($title, $content, $description, $link, $publishedAt, $category, $source);

        $message = !is_null($feed) ? "Feed: $categoryName | $title | $link." : "Failed to add feed: $title | $link.";

        return $message;
    }

    /**
     * @param \SimpleXMLElement $item
     * @return string
     */
    protected function extractCategoryName(\SimpleXMLElement $item): string
    {
        return is_null($item->category) ? FeedConstant::DEFAULT_CATEGORY : $item->category->label;
    }

    protected function getContent(\SimpleXMLElement $item)
    {
        return $item->{'content:encoded'};
    }

    private function getSource(string $url)
    {
        $source = FeedSource::where('link', $url)->first();
        if (is_null($source)) {
            $source = FeedSource::create(
                [
                    'name' => $url,
                    'link' => $url,
                    'created_at' => new \DateTime(),
                ]
            );
        }

        return $source;
    }

    private function getCategory(string $categoryName)
    {
        $category = Category::where('name', $categoryName)->first();
        if (is_null($category)) {
            $category = Category::create(
                [
                    'name' => $categoryName,
                    'created_at' => new \DateTime(),
                ]
            );
        }

        return $category;
    }

    private function saveFeed(string $title, string $content, string $description, string $link, \DateTime $publishedAt, Category $category, FeedSource $source)
    {
        $feed = new Feed();
        $feed->title = $title;
        $feed->content = $content;
        $feed->description = $description;
        $feed->link = $link;
        $feed->published_at = $publishedAt;
        $feed->category()->associate($category);
        $feed->source()->associate($source);
        $feed->save();

        return $feed;
    }
}
