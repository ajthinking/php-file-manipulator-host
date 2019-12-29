<?php

namespace Ajthinking\PHPFileManipulator\Resources;

use Ajthinking\PHPFileManipulator\BaseResource;
use PhpParser\NodeFinder;
use PhpParser\Node\Stmt\ClassMethod;

class ClassMethodsResource extends BaseResource
{
    public function get()
    {
        return (new NodeFinder)->findInstanceOf($this->ast(), ClassMethod::class);
    }
    
    public function add($method)
    {
        return (new NodeFinder)->findInstanceOf($this->ast(), ClassMethod::class);
    }
}