<?php

use Ajthinking\PHPFileManipulator\QueryBuilder;

Artisan::command('php:query {path?} {signature?}', function ($path = '', $signature = '/\.php$/') {
    (new QueryBuilder)->all($path, $signature);
});