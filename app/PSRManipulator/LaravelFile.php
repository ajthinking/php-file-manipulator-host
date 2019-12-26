<?php

namespace App\PSRManipulator;

use App\PSRManipulator\PHPFile;

class LaravelFile extends PHPFile 
{
    protected $extraResources = [
        'casts',
        'fillable',
        'hidden',
        'routes',
        'hasManyMethod' // get, set, add, remove
    ];
}