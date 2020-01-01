<?php

namespace Ajthinking\PHPFileManipulator\Tests\Unit\Resources;

use Ajthinking\PHPFileManipulator\Tests\TestCase;
use Ajthinking\PHPFileManipulator\PHPFile;
use Ajthinking\PHPFileManipulator\LaravelFile;

class HasManyMethodsTest extends TestCase
{
    /** @test */
    public function it_can_load_laravel_files()
    {
        $file = $this->laravelUserFile();

        //$file = $file->addHasManyMethods([]);

        $this->assertInstanceOf(
            LaravelFile::class, $file
        );
    }
}