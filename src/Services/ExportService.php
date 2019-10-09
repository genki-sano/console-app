<?php
declare(strict_types = 1);

namespace ConsoleApp\Console\Services;

class ExportService
{
    /** @var string 出力先のディレクトリ */
    private $fileDir;

    /**
     * ExportService constructor.
     */
    public function __construct()
    {
        // 出力先のディレクトリを指定
        $this->fileDir = base_path('storage') . DIRECTORY_SEPARATOR;
    }

    /**
     * ファイルに出力
     * @param string $output
     * @param string $fileName
     * @return int
     */
    public function execute($output, $fileName): int
    {
        // 出力するファイルのパスを指定
        $filePath = $this->fileDir . $fileName;

        // ファイルに書き込み
        return file_put_contents($filePath, $output);
    }
}