<?php
declare(strict_types = 1);

namespace ConsoleApp\Console\Command;

use ConsoleApp\Console\Services\ConvertRssFeedService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class console
 */
final class RssReaderCommand extends Command
{
    /** @var string command name */
    protected $command = 'RssReader [url] [options]';
    /** @var string command description */
    protected $description = 'RSS feed generator for a command';

    /**
     * Execute the console command.
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function action(InputInterface $input, OutputInterface $output)
    {
//        $url = 'https://news.yahoo.co.jp/pickup/rss.xml';
        $url = 'https://qiita.com/tags/php/feed.atom';

        // simplexml_load_file()でRSSをパースしてオブジェクトを取得
        $rss = simplexml_load_file($url);

        // オブジェクトが空でなければブロック内を処理
        if ($rss) {
            // 出力用に整形
            $convert = new ConvertRssFeedService($rss);
            $outputData = $convert->outputData();

            $output->writeln($outputData);
        }
    }
}