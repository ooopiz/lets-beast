<?php

namespace Rickyfun\LetsBeast\Commands;


use Illuminate\Console\Command;
use Rickyfun\LetsBeast\Beast\BeastService;

class BeastCleanCache extends Command
{
    /**
     * @var string
     */
    protected $signature = 'beast:clean-cache';

    /**
     * @var string
     */
    protected $description = 'Clear beast cache';

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

        $this->beastService->cleanCache();
    }
}