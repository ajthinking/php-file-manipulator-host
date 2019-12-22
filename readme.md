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
    public function it_can_read_from_disc()
    {
        $file = PSRFile::load(
            $this->samplePath('app/User.php')
        );

        $this->assertTrue(
            get_class($file) === 'App\PSRManipulator\PSRFile'
        );
    }

    /** @test */
    public function it_can_write_to_a_file_to_disc()
    {
        // Save a copy
        $this->userFile()->save(
            $this->samplePath('.output/User.php')
        );

        // Read it
        $copy = PSRFile::load(
            $this->samplePath('.output/User.php')
        );

        // Ensuring it is valid
        $this->assertTrue(
            get_class($copy) === 'App\PSRManipulator\PSRFile'
        );

        // NOTE: When pretty printing some of the array formatting may change
        // For instance the $fillable array in Laravels default User class
        // Compare Filesamples/User.php <---> Filesamples/.output/User.php
        // For now expect non identical ASTs
        $this->assertTrue(
            json_encode($this->userFile()->ast()) != json_encode($copy->ast())
        );
    }    

    /** @test */
    public function it_can_retrieve_namespace()
    {
        // on a file with namespace
        $this->assertTrue(
            $this->userFile()->namespace() === 'App'
        );

        // on a file without namespace
        $this->assertTrue(
            $this->routesFile()->namespace() === null
        );
    }

    /** @test */
    public function it_can_set_namespace()
    {
        // on a file with namespace
        $this->assertTrue(
            $this->userFile()->namespace('New\Namespace')->namespace() === 'New\Namespace'
        );

        // on a file without namespace
        $this->assertTrue(
            $this->routesFile()->namespace('New\Namespace')->namespace() === 'New\Namespace'
        );        
    }    
    
    /** @test */
    public function it_can_retrieve_use_statements()
    {
        $file = $this->userFile();
        $file = $this->routesFile();
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
    
    /** @test */
    public function it_can_set_class_name()
    {
        // on a file with a class
        $this->assertTrue(
            $this->userFile()->className("NewName")->className() === "NewName"
        );

        // on a file without a class
        $this->assertTrue(
            $this->routesFile()->className("NewName")->className() === null
        );        
    }     

    protected function samplePath($name)
    {
        return "tests/Unit/FileSamples/$name";
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


```

## Currently does not support
* `GroupUse`, example:  `use Package\{Alfa, Beta};`

## TODO

### General 

| task | status |
|------|--------|
| Create a dedicated Storage disk (storage/php-file-manipulator/preview etc) | - |
| Solve difference for namespaced and not namespaced files | - |
| it_can_add_use_statements_with_alias | - |

### API


| resource       | get| set | add | remove |
|----------------|----|-----|-----|--------|
| namespace      | X  | X   | N/A | X      |
| namespaceNS    | X  | X   | N/A | X      |
| useStatements  | X  | X   | X   | -      |
| useStatements0U|  - | -   | -   | -      |
| className      |  - | -   | -   | -      |
| classExtends   |  - | -   | -   | -      |
| classImplements|  - | -   | -   | -      |
| traits         |  - | -   | -   | -      |
| properties     |  - | -   | -   | -      |
| methods        |  - | -   | -   | -      |