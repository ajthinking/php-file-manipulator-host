<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\PSRManipulator\PSRFile;
use NamespaceTests;

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
            $file->relativePath() === 'tests/FileSamples/app/User.php'
        );

        $this->assertTrue(
            $file->path() === base_path('tests/FileSamples/app/User.php')
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
            'storage/.preview/tests/FileSamples/app/User.php'
        );

        // It is valid
        $this->assertTrue(
            get_class($preview) === 'App\PSRManipulator\PSRFile'
        );        
    }   
}
