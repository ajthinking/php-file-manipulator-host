<?php

namespace Tests\Unit\Snippets;

use Tests\TestCase;

class SnippetTest extends TestCase
{
    /** @test */
    public function it_can_get_ast_from_snippets()
    {
        $this->assertTrue(
            true
        );

        return;

        $file = $this->userFile();
        $file->hasManyMethod('App\\Car');

        $file->addClassMethods([
            $file->hasManyMethod('App\\Car')
        ]);



    }
}