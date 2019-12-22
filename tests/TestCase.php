<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\PSRManipulator\PSRFile;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function samplePath($name)
    {
        return "tests/FileSamples/$name";
    }

    protected function userFile()
    {
        return PSRFile::load(
            $this->samplePath('app/User.php')
        );        
    }
    
    protected function routesFile()
    {
        return PSRFile::load(
            $this->samplePath('routes/web.php')
        );        
    }    
}
