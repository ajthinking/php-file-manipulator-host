<?php

namespace Ajthinking\PHPFileManipulator\Resources;

use Ajthinking\PHPFileManipulator\BaseResource;
use PhpParser\NodeFinder;
use PhpParser\Node\Stmt\Class_;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\Print_;
use PhpParser\Node\Expr\Variable;
use ReflectionClass;
use Illuminate\Support\Str;

class HasManyMethodsResource extends BaseResource
{
    public function add($target)
    {
        $factory = new BuilderFactory;
        $classNameParts = explode('\\', $target);
        $className = end($classNameParts);
        $methodName = Str::camel(
            Str::plural($className)
        );

        /** Make use of PHPFile ClassMethods Resource */
        $this->file->addClassMethods([            
            $factory->method($methodName)
                ->addStmt(new Print_(new Variable('HASMANY_STUFF')))
                ->getNode()            
        ]);

        return $this->file;
    }
}