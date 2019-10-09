<?php
declare(strict_types = 1);

namespace ConsoleApp\Console\Command;

use ConsoleApp\Console\Services\ConvertService;
use ConsoleApp\Console\Services\ExportService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class console
 */
final class RssReaderCommand extends Command
{
    /** @var string command name */
    protected $command = 'RssReader';
    /** @var string command description */
    protected $description = 'RSS feed generator for a command';

    /**
     * Add arguments and options.
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDefinition([
            new InputArgument('url', InputArgument::REQUIRED, 'RSS feed'),
            new InputArgument('file-name', InputArgument::REQUIRED, 'Export file name'),
            new InputOption('strip', '-a', InputOption::VALUE_NONE, 'Cut title and body', null),
            new InputOption('convert', '-b', InputOption::VALUE_NONE, 'Convert string', null),
        ]);
        parent::configure();
    }

    /**
     * Execute the console command.
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function action(InputInterface $input, OutputInterface $output)
    {
        // URLを取得
        $url = $input->getArgument('url');
        // ファイル名を取得
        $fileName = $input->getArgument('file-name');

        // 取得できないときはテキストファイルとして読込
        $content = file_get_contents($url);

        // RSSの時はパースしてオブジェクトを取得
        if (substr($content, 0, 5) === '<?xml') {
            $content = simplexml_load_file($url);
        }

        // 取得できないときはエラー
        if (!$content) {
            $output->writeln('Fatal err: Illegal request!');
            exit(1);
        }

        // 出力用に整形
        $convert = new ConvertService($content, $input->getOptions());
        $outputData = $convert->generateOutputData();

        if ($fileName === 'print') {
            // 標準出力で出力
            $output->writeln($outputData);
        } else {
            // 指定したファイルに出力
            $export = new ExportService();
            if ($export->execute($outputData, $fileName) !== false) {
                $output->writeln('complete!');
            }
        }

    }
}