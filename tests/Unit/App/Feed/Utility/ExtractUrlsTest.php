<?php

namespace App\Feed\Utility;

use Exception;
use Tests\TestCase;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class ExtractUrlsTest extends TestCase
{
    use ArraySubsetAsserts, ExtractUrls;

    /**
     * Test extract url function
     *
     * @return void
     * @throws Exception
     */
    public function testExtractUrls()
    {
        $urlList = $this->extractUrls('http://www.feedforall.com/sample.xml,http://www.feedforall.com/sample-feed.xml');
        self::assertArraySubset(['http://www.feedforall.com/sample.xml','http://www.feedforall.com/sample-feed.xml'], $urlList);
    }

    /**
     * Test extract url function
     *
     * @return void
     * @throws Exception
     */
    public function testExtractDuplicateUrls()
    {
        $urlList = $this->extractUrls('http://www.feedforall.com/sample.xml,http://www.feedforall.com/sample-feed.xml,http://www.feedforall.com/sample.xml');
        self::assertArraySubset(['http://www.feedforall.com/sample.xml','http://www.feedforall.com/sample-feed.xml'], $urlList);
    }
}
