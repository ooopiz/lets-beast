<?php

namespace Rickyfun\LetsBeast\Commands;


use Illuminate\Console\Command;
use Rickyfun\LetsBeast\Beast\BeastService;

class BeastEncode extends Command
{
    /**
     * @var string
     */
    protected $signature = 'beast:encode {--file=} {--folder=}';

    /**
     * @var string
     */
    protected $description = '...';

    private $basePath;

    private $beastService;

    public function __construct()
    {
        parent::__construct();

        $this->basePath = base_path();
        $this->beastService = new BeastService();
    }

    public function handle()
    {
        $this->beastService->validateLoaded();

        $fileValue = $this->option('file');
        $folderValue = $this->option('folder');
        $hasFile = is_null($fileValue) ? false : true;
        $hasFolder = is_null($folderValue) ? false : true;

        if ($hasFile && $hasFolder) {
            $this->error('Does not support file and folder together');
            return;
        }

        // file
        if ($hasFile) {
            $fileRealPath = $this->basePath . '/'. $fileValue;
            $this->beastService->encodeFile($fileRealPath, $fileRealPath, 0, $this->beastService->typeDefine('AES'));
        }

        // folder
        if ($hasFolder) {
            $dirRealPath = $this->basePath . '/' . $folderValue;
            $this->beastService->calculate_directory_schedule($dirRealPath);
            $this->beastService->encrypt_directory($dirRealPath, $dirRealPath, 0, $this->beastService->typeDefine('AES'));
        }

        // no input
        if ((!$hasFile) && (!$hasFolder)) {
            // todo default encode
        }
    }
}