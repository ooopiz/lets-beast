<?php

namespace Rickyfun\LetsBeast;

use Carbon\Laravel\ServiceProvider;
use Rickyfun\LetsBeast\Commands\BeastAvailCache;
use Rickyfun\LetsBeast\Commands\BeastCleanCache;
use Rickyfun\LetsBeast\Commands\BeastEncode;
use Rickyfun\LetsBeast\Commands\BeastFileExpire;
use Rickyfun\LetsBeast\Commands\BeastSupportFileSize;
use Rickyfun\LetsBeast\Commands\TestCommand;

class LetsBeastProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands(BeastEncode::class);
        $this->commands(BeastFileExpire::class);
        $this->commands(BeastSupportFileSize::class);
        $this->commands(BeastAvailCache::class);
        $this->commands(BeastCleanCache::class);
    }
}