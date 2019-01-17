<?php

namespace App\PSRManipulator;

class Stub {
    public static function for($name)
    {
        return file_get_contents(
            base_path('app/PSRManipulator/Stubs/Laravel/' . $name)
        );
    }
}