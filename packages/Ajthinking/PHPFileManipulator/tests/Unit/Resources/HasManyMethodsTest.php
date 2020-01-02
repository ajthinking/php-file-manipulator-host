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
    public function it_can_insert_a_has_many_method()
    {
        $file = $this->laravelUserFile();
        $file->addHasManyMethods('App\Post');

        $this->assertContains(
            'posts',
            $file->classMethodNames()
        );
    }    
}