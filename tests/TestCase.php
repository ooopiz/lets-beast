<?php

namespace Rickyfun\LetsBeast\Tests;


class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Rickyfun\LetsBeast\LetsBeastProvider::class
        ];
    }
}