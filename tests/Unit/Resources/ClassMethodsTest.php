<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use App\PSRManipulator\PSRFile;

class ClassMethodsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_class_method_names()
    {
        $file = $this->userFile();

        $this->assertTrue(
            $file->methodNames() === ['cars']
        );
    }

    /** @wip-test */
    public function it_can_retrieve_class_method_asts()
    {
        $methods = $this->userFile()->classMethods();

            collect($methods)->map(function() {
                $this->assertTrue(
                    // put is instance of ClassMethod
                );
            });

    }    
}