<?php

namespace App\Feed;

use Illuminate\Support\Facades\Storage;

class FeedLogger
{
    private $logFilename;

    /**
     * FeedLogger constructor.
     */
    public function __construct()
    {
        $this->logFilename = env('FEED_LOG_FILENAME', 'feed.log');
    }

    public function log($message)
    {
        Storage::disk('feed')->append($this->logFilename, $message);
    }
}