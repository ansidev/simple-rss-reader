<?php

namespace App\Feed\Utility;

use Tests\TestCase;

class ExtractUrlsTest extends TestCase
{
    use ExtractUrls;

    /**
     * Test extract url function
     *
     * @return void
     */
    public function testExtractUrls()
    {
        $urlList = $this->extractUrls('http://www.feedforall.com/sample.xml,http://www.feedforall.com/sample-feed.xml');
        $this->assertArraySubset(['http://www.feedforall.com/sample.xml','http://www.feedforall.com/sample-feed.xml'], $urlList);
    }

    /**
     * Test extract url function
     *
     * @return void
     */
    public function testExtractDuplicateUrls()
    {
        $urlList = $this->extractUrls('http://www.feedforall.com/sample.xml,http://www.feedforall.com/sample-feed.xml,http://www.feedforall.com/sample.xml');
        $this->assertArraySubset(['http://www.feedforall.com/sample.xml','http://www.feedforall.com/sample-feed.xml'], $urlList);
    }
}
