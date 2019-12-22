<?php

use PipeDream\Laravel\LaravelProject as Laravel;
use PipeDream\Laravel\LaravelModel as Model;
use PipeDream\Laravel\LaravelFile as File;

/** Tinkering with a project abstraction idea */
Laravel::new('blog')
    ->models([
        Model::User()
            ->attributes([
                'car_id'
            ]),
        Model::make('Car')
            ->attributes([
                'color : string, required'
            ]),            
    ])
    ->files([
        File::Model::class,
        File::Controller::class,
        File::Migration::class,
        File::Policy::class,
        File::Routes::class,
    ])
    ->env([
        "AWS_SECRET" => "asfaybsofasbfpsafboasfboauvafv"
    ]);
    
/** More tinkering */
$User = File::load('app/User.php')
    ->hasMany('App\Car')
    ->fillable('name');
    ->save()


NAMES:
PHP-file-manipulator
PSR-file-manipulator
Project Abstractor
PHP abstractor
Laravel Abstractor
Laravel Abstracthor
Laravel Abstractify

$model->method(
    'users',
    Laravel::hasManyMethod($model::class, User::class)
);

ProjectAbstractor::collection([
    LaravelFile::load('app/User.php')
        ->addUseStatement('Package\TenX')
        ->addHasManyMethod('App\Developer')
        ->addFillable('is_happy')
        ->save(),

    LaravelFile::model('app/Car.php')
        ->addUseStatement('Package\TenX')
        ->addHasManyMethod('App\Developer')
        ->addFillable('is_happy')
        ->preview(),

    LaravelFile::model('app/Car.php')
        ->addUseStatement('Package\TenX')
        ->addHasManyMethod('App\Developer')
        ->addFillable('is_happy'),
])->save()->pullRequest()
    

Dont just write code, write code that writes code.
PHP-file-manipulator provides fluent API to read and programtically edit PHP files.
Extra goodies are provided for Laravel framework <3
Some use cases can be
    generate new files,
    harvest data from code,
    automatically fix smelly code,
    post install scripts,
    rapid application development apps,
    integrate packages with existing conflicting code,
    ...

Examples

Add a relationship method

Add something to a fillable array

Deploy a trait

Add a route

Edit configs

Remove use statements

Check for existance of method

Insert scope


php artisan project:addRelationshipMethod 'Car' HasMany('User'))
