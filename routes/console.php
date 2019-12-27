<?php

use Ajthinking\PHPFileManipulator\QueryBuilder;

Artisan::command('php:query {path?} {signature?}', function ($path = '', $signature = '/\.php$/') {
    (new QueryBuilder)->all($path, $signature);
});

Artisan::command('php:test', function () {
    dd(
        (new QueryBuilder)->in('app/Console')->get()
    );
});