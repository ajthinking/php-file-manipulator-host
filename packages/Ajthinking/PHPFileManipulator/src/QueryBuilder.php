<?php

namespace Ajthinking\PHPFileManipulator;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use RecursiveCallbackFilterIterator;

class QueryBuilder
{
    public function all($path, $signature)
    {
        $PHPSignature = '/\.php$/';
        $JSONSignature = '/\.json$/';

        dd(
            $this->recursiveFileSearch(
                $path,
                $signature
            )
        );
    }

    public function in($args)
    {
        //    
    }
    
    public function where($args)
    {
        // resource query
        // filename query
        // function query
    }
    
    private function recursiveFileSearch($directory, $signature) {
        $directory = base_path($directory);

        // Will exclude everything under these directories
        $exclude = array('vendor', '.git', 'node_modules');
        
        /**
         * @param SplFileInfo $file
         * @param mixed $key
         * @param RecursiveCallbackFilterIterator $iterator
         * @return bool True if you need to recurse or if the item is acceptable
         */
        $filter = function ($file, $key, $iterator) use ($exclude, $signature) {
            // Iterate recursively - except excludes folder
            if ($iterator->hasChildren() && !in_array($file->getFilename(), $exclude)) {
                return true;
            }

            // Accept any file matching signature
            return $file->isFile() && preg_match($signature, $file->getFilename());
        };
        
        $innerIterator = new RecursiveDirectoryIterator(
            $directory,
            RecursiveDirectoryIterator::SKIP_DOTS
        );
        $iterator = new RecursiveIteratorIterator(
            new RecursiveCallbackFilterIterator($innerIterator, $filter)
        );
        
        foreach ($iterator as $pathname => $fileInfo) {
            // do your insertion here
        }

        return collect(iterator_to_array($iterator))->map(function($file) {
            return $file->getFilename();
        })->keys();
    }
}