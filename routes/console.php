<?php

Artisan::command('psr:namespace', function () {
    $this->info(
        dd(
            PSRFile::load('app/Console/Kernel.php')->namespace('BadAss\\NameSpace\\IsCool')
                ->namespace()
        )
    );
});

Artisan::command('psr:ast', function () {
    dd(
        PSRFile::load('app/User.php')->ast()
    );    
});

Artisan::command('psr:save', function () {
    PSRFile::load('app/User.php')->save('app/Benno.php');
});

Artisan::command('psr:method', function () {

    $classMethodStatements = PSRFile::load(
        'app/PSRManipulator/Stubs/Laravel/HAS_MANY.stub.php'
    )->ast()[0]->stmts;
    
    PSRFile::load('app/User.php')
        ->addClassMethod($classMethodStatements)
        ->save('app/Benno.php');
});

Artisan::command('psr:migration', function () {
    //PSRFile::load('database/migrations/2014_10_12_000000_create_users_table.php')->save('app/Benno.php');
    dd(
        PSRFile::load('database/migrations/2014_10_12_000000_create_users_table.php')->ast()
    );
});

Artisan::command('psr:sample {path}', function ($path) {
    PSRFile::load("tests/FileSamples/$path")
        ->save('tests/FileSamples/.output/' . basename($path));
});