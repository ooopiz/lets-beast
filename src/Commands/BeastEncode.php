<?php

namespace Rickyfun\LetsBeast\Commands;


use Illuminate\Console\Command;
use Rickyfun\LetsBeast\Beast\BeastService;

class BeastEncode extends Command
{
    /**
     * @var string
     */
    protected $signature = 'beast:encode {target}';

    /**
     * @var string
     */
    protected $description = 'Encode files';

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

        $target = $this->argument('target');
        $absTarget = $this->basePath . '/' . $target;
        $isFile = is_file($absTarget);
        $isDir  = is_dir($absTarget);

        if (!$isFile && !$isDir) {
            $this->error($absTarget . "  ==> Target not found.");
            return;
        }

        $encodeType = $this->beastService->typeDefine('AES');
        switch (true) {
            case ($isFile):
            $this->beastService->encodeFile($absTarget, $absTarget, 0, $encodeType);
            break;

            case ($isDir):
            $this->beastService->calculate_directory_schedule($absTarget);
            $this->beastService->encrypt_directory($absTarget, $absTarget, 0, $encodeType);

            default: break;
        }
    }
}