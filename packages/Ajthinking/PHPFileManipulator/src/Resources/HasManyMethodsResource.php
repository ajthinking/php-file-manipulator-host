<?php

namespace Ajthinking\PHPFileManipulator\Resources;

use Ajthinking\PHPFileManipulator\BaseResource;
use PhpParser\NodeFinder;
use PhpParser\Node\Stmt\Class_;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\Print_;
use PhpParser\Node\Expr\Variable;

class HasManyMethodsResource extends BaseResource
{
    public function add($target)
    {
        $factory = new BuilderFactory;
        $target = basename($target);

        /** Make use of PHPFile ClassMethods Resource */
        $this->file->addClassMethods([            
            $factory->method($target)
                ->makeProtected() // ->makePublic() [default], ->makePrivate()
                // it is possible to add manually created nodes
                ->addStmt(new Print_(new Variable('HASMANY_STUFF')))
                ->getNode()            
        ]);

        return $this->file;
    }
}