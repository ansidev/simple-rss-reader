<?php

namespace App\Feed;

class FeedReader
{
    /**
     * @var \SimplePie
     */
    private $feed;

    public function __construct(array $urlArr)
    {
        $this->feed = new \SimplePie();
        $this->feed->set_feed_url($urlArr);
        $this->autoConfig();
    }

    private function autoConfig() {
        $this->feed->set_output_encoding('utf-8');
        $this->feed->enable_cache(true);
        $this->feed->set_cache_location(storage_path() . '/feeds/cache');
        $this->feed->set_cache_duration(60 * 60 * 12);
    }

    public function init()
    {
        $this->feed->init();
        $this->feed->handle_content_type();
    }

    /**
     * Get feed items
     * @return null|\SimplePie_Item[]
     */
    public function getItems()
    {
        return $this->feed->get_items();
    }
}