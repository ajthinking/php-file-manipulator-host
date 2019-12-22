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
    public function it_has_path_getters()
    {
        $file = PSRFile::load(
            $this->samplePath('app/User.php')
        );

        $this->assertTrue(
            $file->relativePath() === 'tests/Unit/FileSamples/app/User.php'
        );

        $this->assertTrue(
            $file->path() === base_path('tests/Unit/FileSamples/app/User.php')
        );        
    }    

    /** @test */
    public function it_can_write_to_disc()
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
    public function it_can_write_to_a_preview_folder()
    {
        // Save it
        $this->userFile()->preview();

        // Load it from the preview folder
        $preview = PSRFile::load(
            // this is long now, when using real files it will be just .preview/app/User.php
            'storage/.preview/tests/Unit/FileSamples/app/User.php'
        );

        // It is valid
        $this->assertTrue(
            get_class($preview) === 'App\PSRManipulator\PSRFile'
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
        // A file with use statements
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

        // A file without use statements
        $file = $this->routesFile();
        $useStatements = $file->useStatements();

        $this->assertTrue(
            collect($useStatements)->count() === 0
        );

    }
    
    /** @test */
    public function it_can_add_use_statements_in_a_namespace()
    {
        // on a file with use statements        
        $file = $this->userFile();
        $useStatements = $file->addUseStatements(['Add\This'])->useStatements();
        $expectedUseStatements = collect([
            "Illuminate\Notifications\Notifiable",
            "Illuminate\Contracts\Auth\MustVerifyEmail",
            "Illuminate\Foundation\Auth\User as Authenticatable",            
            "Add\This",            
        ]);

        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });        
    }

    /** @wip-test */
    public function it_can_add_use_statements_when_not_in_a_namespace()
    {        
        $file = $this->routesFile();
        $useStatements = $file->addUseStatements(['Add\This'])->useStatements();
        $expectedUseStatements = collect([            
            "Add\This",            
        ]);
        
        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });
    }


    /** @wip-test */
    public function it_can_overwrite_use_statements()
    {
        $file = $this->userFile();

        $useStatements = $file->useStatements(['Only\This'])->useStatements();
        $expectedUseStatements = collect([
            "Only\This",
        ]);

        $this->assertTrue(
            collect($useStatements)->count() == 1
        );

        $this->assertTrue(
            $useStatements[0] == 'Only\This'
        );        
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
