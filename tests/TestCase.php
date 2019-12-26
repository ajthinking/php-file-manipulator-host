<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Ajthinking\PHPFileManipulator\PHPFile;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function samplePath($name)
    {
        return "tests/FileSamples/$name";
    }

    protected function userFile()
    {
        return PHPFile::load(
            $this->samplePath('app/User.php')
        );        
    }
    
    protected function routesFile()
    {
        return PHPFile::load(
            $this->samplePath('routes/web.php')
        );        
    }    
}
