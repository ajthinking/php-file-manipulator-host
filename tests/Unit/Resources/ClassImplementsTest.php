<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\PSRManipulator\PSRFile;

class ClassImplementsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_class_implements()
    {
        $file = $this->userFile();

        $this->assertTrue(
            $file->implements() === []
        );
    }

    /** @test */
    public function it_can_set_class_implements()
    {
        $file = $this->userFile()->implements([
        "MyInterface" 
        ]);

        $this->assertTrue(
            $file->implements() === [
                "MyInterface" 
            ]
        );
    }

    /** @test */
    public function it_can_add_class_implements()
    {
        $file = $this->userFile()->addImplements([
        "MyFirstInterface" 
        ])->addImplements([
            "MySecondInterface" 
        ]);

        $this->assertTrue(
            $file->implements() === [
                "MyFirstInterface",
                "MySecondInterface"
            ]
        );
    }    
}