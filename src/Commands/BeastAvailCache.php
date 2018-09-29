<?php

namespace Rickyfun\LetsBeast\Commands;


use Illuminate\Console\Command;
use Rickyfun\LetsBeast\Beast\BeastService;

class BeastAvailCache extends Command
{
    /**
     * @var string
     */
    protected $signature = 'beast:avail-cache';

    /**
     * @var string
     */
    protected $description = 'Get cache size';

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

        $result = $this->beastService->availCache();
        $this->info($result);
    }
}