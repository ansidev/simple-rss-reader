<?php

namespace App\Feed\Utility;

trait ConvertToDateTime
{
    /**
     * Convert timestamp to DateTime object
     * @param int $timestamp
     * @return \DateTime
     */
    private function timestampToDateTime(int $timestamp)
    {
        if ($timestamp < 0) {
            return null;
        }
        $datetime = new \DateTime();
        $datetime->setTimestamp($timestamp);

        return $datetime;
    }
}