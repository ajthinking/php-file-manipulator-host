<?php

namespace Tests\Unit\Resources;

use Tests\TestCase;
use PhpParser\Node\Stmt\ClassMethod;

class ClassMethodsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_class_method_names()
    {
        $file = $this->userFile();

        $this->assertTrue(
            $file->classMethodNames() === ['cars']
        );
    }

    /** @test */
    public function it_can_retrieve_class_method_asts()
    {
        $methods = $this->userFile()->classMethods();

            collect($methods)->each(function($method) {
                $this->assertInstanceOf(ClassMethod::class, $method);
            });
    }
    
    /** @wip-test */
    public function it_can_add_a_class_method()
    {
        $methods = $this->userFile()->addClassMethods([
            LaravelSnippet::method()
        ])->classMethods();

            collect($methods)->each(function($method) {
                $this->assertInstanceOf(ClassMethod::class, $method);
            });
    }    
}