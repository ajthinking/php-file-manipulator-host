<?php

namespace App\PSRManipulator;

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use App\PSRManipulator\PSR2PrettyPrinter;

class PSRFile
{
    public function __construct($fullPath)
    {
        $this->path = $fullPath;
        $this->contents = file_get_contents($this->path);
        # ast - abstract syntax tree
        $this->ast = $this->parse();
    }

    /* STATIC API *********************************/

    static function load($relativePath)
    {
        return new PSRFile(
            base_path($relativePath)
        );
    }

    static function fromString($code)
    {
        // return new PSRFile(
        //     base_path($relativePath)
        // );
    }
    

    /* PUBLIC API **********************************/

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
        if(!$newNamespace)
        {
            return implode('\\', $this->ast[0]->name->parts);
        }

        $this->ast[0]->name->parts = explode("\\",$newNamespace);
        return $this;
    }
    
    public function ast()
    {
        return $this->ast;
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

}
