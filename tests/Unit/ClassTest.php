<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\PSRManipulator\PSRFile;

class ClassTest extends TestCase
{
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
}