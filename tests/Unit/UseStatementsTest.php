<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\PSRManipulator\PSRFile;

class UseStatementsTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_use_statements()
    {
        // A file with use statements
        $file = $this->userFile();
        $useStatements = $file->useStatements();
        $expectedUseStatements = collect([
            "Illuminate\Notifications\Notifiable",
            "Illuminate\Contracts\Auth\MustVerifyEmail",
            "Illuminate\Foundation\Auth\User as Authenticatable",
        ]);

        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });

        // A file without use statements
        $file = $this->routesFile();
        $useStatements = $file->useStatements();

        $this->assertTrue(
            collect($useStatements)->count() === 0
        );

    }
    
    /** @test */
    public function it_can_add_use_statements_in_a_namespace()
    {
        // on a file with use statements        
        $file = $this->userFile();
        $useStatements = $file->addUseStatements(['Add\This'])->useStatements();
        $expectedUseStatements = collect([
            "Illuminate\Notifications\Notifiable",
            "Illuminate\Contracts\Auth\MustVerifyEmail",
            "Illuminate\Foundation\Auth\User as Authenticatable",            
            "Add\This",            
        ]);

        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });        
    }

    /** @test */
    public function it_can_add_use_statements_when_not_in_a_namespace()
    {
                
        $file = $this->routesFile();
        
        $useStatements = $file->addUseStatements(['Add\This'])->useStatements();
        
        $expectedUseStatements = collect([            
            "Add\This",            
        ]);

        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });
    }

    /** @wip-test */
    public function it_can_add_use_statements_with_alias()
    {        
        $file = $this->routesFile();
        $useStatements = $file->addUseStatements(['Add\This as Wow'])->useStatements();
        $expectedUseStatements = collect([            
            "Add\This as Wow",            
        ]);
        
        $expectedUseStatements->each(function($expectedUseStatement) use($useStatements){
            $this->assertTrue(
                collect($useStatements)->contains($expectedUseStatement)
            );
        });
    }    


    /** @wip-test */
    public function it_can_overwrite_use_statements()
    {
        $file = $this->userFile();

        $useStatements = $file->useStatements(['Only\This'])->useStatements();
        $expectedUseStatements = collect([
            "Only\This",
        ]);

        $this->assertTrue(
            collect($useStatements)->count() == 1
        );

        $this->assertTrue(
            $useStatements[0] == 'Only\This'
        );        
    }
}