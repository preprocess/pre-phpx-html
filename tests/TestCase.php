<?php

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function fixtureCode($path, $extension = "txt")
    {
        return trim(file_get_contents(__DIR__ . "/fixtures/{$path}.{$extension}"));
    }
}
