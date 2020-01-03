<?php

namespace Ajthinking\PHPFileManipulator\Tests\Unit\Resources;

use Ajthinking\PHPFileManipulator\Tests\TestCase;
use Ajthinking\PHPFileManipulator\LaravelFile;

class HasManyMethodsTest extends TestCase
{
    /** @test */
    public function it_can_load_laravel_files()
    {
        $file = $this->laravelUserFile();

        $this->assertInstanceOf(
            LaravelFile::class, $file
        );
    }

    /** @test */
    public function it_can_insert_has_many_methods()
    {
        $file = $this->laravelUserFile();
        $file->addHasManyMethods(['App\Gun', 'App\Rose']);

        $this->assertContains(
            'guns',
            $file->classMethodNames()
        );

        $this->assertContains(
            'roses',
            $file->classMethodNames()
        );
    }    
}