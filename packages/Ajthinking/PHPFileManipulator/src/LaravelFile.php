<?php

namespace Ajthinking\PHPFileManipulator;

use Ajthinking\PHPFileManipulator\PHPFile;

class LaravelFile extends PHPFile 
{
    protected $extraResources = [
        'casts',
        'fillable',
        'hidden',
        'routes',
        'hasManyMethod' // get, set, add, remove
    ];

    protected $snippets = [
        'hasManyMethod',
    ];
}