<?php
declare(strict_types = 1);

namespace ConsoleApp\Console\Services;

class ConvertService
{
    /** @var array 各種オプション */
    private $options = [];
    /** @var array 出力データ */
    private $outputData = [];

    /**
     * ConvertService constructor.
     * @param mixed $content
     * @param array $options
     */
    public function __construct($content, $options = [])
    {
        $this->options = $options;

        switch (true) {
            case $content->entry:
                $this->outputData = $this->toOutputDataFromAtom($content);
                break;
            case $content->channel->item:
                $this->outputData = $this->toOutputDataFromRss20($content);
                break;
            case $content->item:
                $this->outputData = $this->toOutputDataFromRss10($content);
                break;
            default:
                $this->outputData = $this->toOutputDataFromString($content);
                break;
        }
    }

    /**
     * 出力用データを作成
     * @return string
     */
    public function generateOutputData(): string
    {
        $re = '------------------------------------------' . PHP_EOL;

        foreach ($this->outputData as $items) {
            // 変換Aの反映
            $title = ($this->options['strip']) ? mb_substr($items['title'], 0, 10) : $items['title'];
            $body  = ($this->options['strip']) ? mb_substr($items['body'], 0, 30)  : $items['body'];
            // 変換Bの反映
            $body  = ($this->options['convert']) ? str_replace('ユーザベース', 'UZABASE', $body) : $body;

            // 出力用に整形
            $re .= 'title: ' . $title . PHP_EOL;
            $re .= 'body: ' . $body . PHP_EOL;
            $re .= '------------------------------------------' . PHP_EOL;
        }

        return $re;
    }

    /**
     * Atom を配列に変換
     * @param $xml
     * @return array
     */
    private function toOutputDataFromAtom($xml): array
    {
        $re = [];
        foreach ($xml->entry as $item) {
            $tmpArray = [];

            $tmpArray['title'] = (string)$item->title;
            $tmpArray['body']  = (string)strip_tags_lf($item->content);

            $re[] = $tmpArray;
        }

        return $re;
    }

    /**
     * RSS2.0 を配列に変換
     * @param $xml
     * @return array
     */
    private function toOutputDataFromRss20($xml): array
    {
        $re = [];
        foreach ($xml->channel->item as $item) {
            $tmpArray = [];

            $tmpArray['title'] = (string)$item->title;
            $tmpArray['body']  = (string)strip_tags_lf($item->description);

            $re[] = $tmpArray;
        }

        return $re;
    }

    /**
     * RSS1.0 を配列に変換
     * @param $xml
     * @return array
     */
    private function toOutputDataFromRss10($xml): array
    {
        $re = [];
        foreach ($xml->item as $item) {
            $tmpArray = [];

            $tmpArray['title'] = (string)$item->title;
            $tmpArray['body']  = (string)strip_tags_lf($item->description);

            $re[] = $tmpArray;
        }

        return $re;
    }

    /**
     * 文字列を配列に変換
     * @param $content
     * @return array
     */
    private function toOutputDataFromString($content): array
    {
        // todo 文字列を配列に変換
    }
}