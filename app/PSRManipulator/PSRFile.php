<?php

namespace App\PSRManipulator;

use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\NodeFinder;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use App\PSRManipulator\PSR2PrettyPrinter;
use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\PrettyPrinter;

class SimpleVisitor extends NodeVisitorAbstract {
    public function leaveNode(Node $node)
    {
        if($node)
        return [$node];
    }
}

class PSRFile
{
    /* Create instance **********************************/

    public function __construct($fullPath)
    {
        $this->path = $fullPath;
        $this->contents = file_get_contents($this->path);
        # ast - abstract syntax tree
        $this->ast = $this->parse();
    }

    static function load($relativePath)
    {
        return new PSRFile(
            base_path($relativePath)
        );
    }

    /* API **********************************/

    public function path()
    {
        return $this->path;
    }

    public function contents()
    {
        return $this->contents;
    }

    public function namespace($newNamespace = false)
    {
        return $newNamespace ? $this->setNamespace($newNamespace) : $this->getNamespace();
    }

    public function useStatements($newUseStatements = false)
    {
        return $newUseStatements ? $this->setUseStatements($newUseStatements) : $this->getUseStatements();
    }

    public function className($newClassName = false)
    {
        return $newClassName ? $this->setClassName($newClassName) : $this->getClassName();
    }
    
    public function classMethods()
    {
        dd(
            (new NodeFinder)->findInstanceOf($this->ast, Node\Stmt\ClassMethod::class)
        );
    }

    public function addClassMethod($classMethodStatements)
    {
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new class($classMethodStatements) extends NodeVisitorAbstract {
            public function __construct($classMethodStatements)
            {
                $this->classMethodStatements = $classMethodStatements;
            }

            public function enterNode(Node $node) {
                if ($node instanceof Class_) {
                    //array_push($node->stmts, $node->stmts[2]);
                    $node->stmts = array_merge($node->stmts, $this->classMethodStatements);
                }
            }
        });

        $this->ast = $traverser->traverse($this->ast);

        return $this;
    }

    public function save($newRelativePath = false)
    {
        if($newRelativePath)
        {
            $this->path = base_path($newRelativePath);
        }

        // write current ast to file
        $prettyPrinter = new PSR2PrettyPrinter;



        $newCode = $prettyPrinter->prettyPrintFile($this->ast);
        file_put_contents($this->path,$newCode);

        return $this;
    } 

    /* PRIVATE *******************************************/

    public function ast()
    {
        return $this->ast;
    }   

    private function getNamespace()
    {
        return implode('\\', $this->ast[0]->name->parts);
    }

    private function setNamespace($newNamespace)
    {
        $this->ast[0]->name->parts = explode("\\", $newNamespace);
        return $this;
    }    

    private function getUseStatements()
    {
        return collect((new NodeFinder)->findInstanceOf($this->ast[0], Node\Stmt\Use_::class))
            ->map(function($useStatement) {
                return collect($useStatement->uses)->map(function($useStatement) {
                    $base = join('\\', $useStatement->name->parts); 
                    return $base . ($useStatement->alias ? ' as ' . $useStatement->alias : '');
                });
            })->flatten()->toArray();
    }

    // VALID INPUT
    // [[name parts, bla bla]]

    // STRATEGY *************************************
    // find last occurance?
    // replace, remove, edit, or move occurance
    // insert occurance

    // FOR NOW ONLY ADD!
    private function setUseStatements($newUseStatement)
    {
        $traverser = new NodeTraverser();
        $visitor = new UseStatementInserter($this->ast, $newUseStatement);
        $traverser->addVisitor($visitor);

        $this->ast = $traverser->traverse($this->ast);

        return $this;
    }    

    private function getClassName()
    {
         return (new NodeFinder)->findFirstInstanceOf($this->ast, Node\Stmt\Class_::class)->name->name;        
    }

    private function setClassName($newClassName)
    {
        return implode('\\', $this->ast[0]->name->parts);
    }    

    public function parse()
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($this->contents);
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }

        return $ast;
    }

    public function print()
    {
        $prettyPrinter = new PSR2PrettyPrinter;
        dd($prettyPrinter->prettyPrintFile($this->ast));
    }
}
