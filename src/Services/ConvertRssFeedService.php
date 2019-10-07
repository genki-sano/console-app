<?php

namespace ConsoleApp\Console\Services;

class ConvertRssFeedService
{
    private $rss = [];

    public function __construct($xml)
    {
        switch (true) {
            case $xml->entry:
                $this->convertArrayFromAtom($xml);
                break;
            case $xml->channel->item:
                $this->convertArrayFromRss($xml);
                break;
        }
    }

    public function outputData()
    {
        $outputData = '------------------------------------------' . PHP_EOL;

        foreach ($this->rss as $items) {
            $outputData .= 'title: ' . mb_substr($items['title'], 0, 10) . PHP_EOL;
            $outputData .= 'date: ' . $items['date'] . PHP_EOL;
            $outputData .= 'link: ' . $items['link'] . PHP_EOL;
            $outputData .= 'dec: ' . mb_substr($items['dec'], 0, 30) . PHP_EOL;
            $outputData .= '------------------------------------------' . PHP_EOL;
        }

        return $outputData;
    }

    private function convertArrayFromRss($xml)
    {
        $re = [];
        foreach ($xml->channel->item as $item) {
            $tmpArray = [];

            $tmpArray['title'] = (string)$item->title;
            $tmpArray['date']  = date('Y/m/d H:i', strtotime((string)$item->pubDate));
            $tmpArray['link']  = (string)$item->link;
            $tmpArray['dec']   = (string)$item->description;

            $re[] = $tmpArray;
        }

        $this->rss = $re;
    }

    private function convertArrayFromAtom($xml)
    {
        $re = [];
        foreach ($xml->entry as $item) {
            $tmpArray = [];

            $tmpArray['title'] = (string)$item->title;
            $tmpArray['date']  = date('Y/m/d H:i', strtotime((string)$item->published));
            $tmpArray['link']  = (string)$item->link->attributes()->href;
            $tmpArray['dec']   = (string)strip_tags($item->content);

            $re[] = $tmpArray;
        }

        $this->rss = $re;
    }
}