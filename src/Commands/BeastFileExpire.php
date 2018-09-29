<?php

namespace Rickyfun\LetsBeast\Commands;


use Illuminate\Console\Command;
use Rickyfun\LetsBeast\Beast\BeastService;

class BeastFileExpire extends Command
{
    /**
     * @var string
     */
    protected $signature = 'beast:file-expire {file}';

    /**
     * @var string
     */
    protected $description = 'Get a file expire time';

    private $beastService;

    public function __construct()
    {
        parent::__construct();

        $this->beastService = new BeastService();
    }

    /**
     *
     */
    public function handle()
    {
        $this->beastService->validateLoaded();

        $file = $this->argument('file');
        $result = $this->beastService->fileExpire($file);
        $this->info($result);
    }
}