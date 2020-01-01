<?php

namespace Ajthinking\PHPFileManipulator\Resources;

use Ajthinking\PHPFileManipulator\BaseResource;
use PhpParser\NodeFinder;
use PhpParser\Node\Stmt\Class_;

class HasManyMethodsResource extends BaseResource
{
    public function add($target)
    {
        $class = (new NodeFinder)->findFirstInstanceOf($this->ast(), Class_::class);
        return "Cool!";        
    }
}