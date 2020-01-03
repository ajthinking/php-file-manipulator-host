<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ajthinking\PHPFileManipulator\PHPFile;

class ListAPICommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // PHPFile::in('packages/Ajthinking/PHPFileManipulator/src/Resources')->get()
        //     ->map(function($file) {
        //         return $file->classMethodNames();
        //     });


        $file = PHPFile::load('packages/Ajthinking/PHPFileManipulator/src/Resources/ClassNameResource.php');

        $this->info(
            $file->className() . " --> " . 
            collect($file->classMethodNames())->implode(' | ')
        );
        
    }
}
