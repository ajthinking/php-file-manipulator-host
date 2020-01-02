<?php

namespace Ajthinking\PHPFileManipulator\Resources;

use Ajthinking\PHPFileManipulator\BaseResource;
use PhpParser\NodeFinder;
use PhpParser\Node\Stmt\Class_;

class HasManyMethodsResource extends BaseResource
{
    public function add($target)
    {
        /** Make a shortcut here - so it can make use of PHPFile ClassMethods Resource */
    }
}