<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\PSRManipulator\PSRFile;

class ClassExtendsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_class_extends()
    {
        $file = $this->userFile();

        $this->assertTrue(
            $file->extends() === 'Authenticatable'
        );
    }

    /** @test */
    public function it_can_set_class_implements()
    {
        $file = $this->userFile()->extends("My\BaseClass");

        $this->assertTrue(
            $file->extends() === "My\BaseClass"
        );
    } 
}