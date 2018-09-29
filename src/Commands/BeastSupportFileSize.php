<?php

namespace Rickyfun\LetsBeast\Commands;


use Illuminate\Console\Command;
use Rickyfun\LetsBeast\Beast\BeastService;

class BeastSupportFileSize extends Command
{
    /**
     * @var string
     */
    protected $signature = 'beast:support-filesize';

    /**
     * @var string
     */
    protected $description = 'Get max support size';

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

        $result = $this->beastService->supportFileSize();
        $this->info($result);
    }
}