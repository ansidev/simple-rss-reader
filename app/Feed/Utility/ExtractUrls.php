<?php

namespace App\Feed\Utility;

trait ExtractUrls
{
    /**
     * @param string $urls
     * @return array
     */
    private function extractUrls(string $urls)
    {
        $urlArr = explode(',', $urls);
        return array_unique($urlArr);
    }
}