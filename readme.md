# PHP-FILE-MANIPULATOR
> Danger zone! Tools to manipulate PHP file on disk. WIP.

Get started by looking at the tests
```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\PSRManipulator\PSRFile;

class PSRFileTest extends TestCase
{
    /** @test */
    public function it_can_instanciate_from_a_sample_file()
    {
        $file = PSRFile::load(
            $this->samplePath('User.php')
        );

        $this->assertTrue(
            get_class($file) === 'App\PSRManipulator\PSRFile'
        );
    }

    /** @test */
    public function it_can_retrieve_namespace()
    {
        $this->assertTrue(
            $this->userFile()->namespace() === 'App'
        );
    }

    /** @test */
    public function it_can_set_namespace()
    {
        $file = $this->userFile();
        $this->assertTrue(
            $file->namespace('New\Namespace')->namespace() === 'New\Namespace'
        );
    }    
    
    /** @test */
    public function it_can_retrieve_use_statements()
    {
        $file = $this->userFile();
        $useStatements = $file->useStatements();
        $expectedUseStatements = collect([
            "Illuminate\Notifications\Notifiable",
            "Illuminate\Contracts\Auth\MustVerifyEmail",
            "Illuminate\Foundation\Auth\User as Authenticatable",
        ]);

        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });
    }
    
    /** @test */
    public function it_can_add_use_statements()
    {
        $file = $this->userFile();

        $useStatements = $file->useStatements('App\Some\New\Model')->useStatements();
        $expectedUseStatements = collect([
            "Illuminate\Notifications\Notifiable",
            "Illuminate\Contracts\Auth\MustVerifyEmail",
            "Illuminate\Foundation\Auth\User as Authenticatable",
            "App\Some\New\Model",
        ]);

        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });
    }

    /** @test */
    public function it_can_retrieve_class_name()
    {
        $file = $this->userFile();

        $this->assertTrue(
            $file->className() === "User"
        );
    }    

    protected function samplePath($name)
    {
        return 'tests/Unit/FileSamples/User.php';
    }

    protected function userFile()
    {
        return PSRFile::load(
            $this->samplePath('User.php')
        );        
    }    
}

```