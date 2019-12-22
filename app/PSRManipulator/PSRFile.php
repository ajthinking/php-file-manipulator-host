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
use Illuminate\Support\Facades\Storage;

use App\PSRManipulator\PSRFileInterface;

class PSRFile implements PSRFileInterface
{
    /* Create instance **********************************/

    public function __construct($relativePath)
    {
        $this->path = base_path($relativePath);
        $this->relativePath = $relativePath;
        
        $this->contents = file_get_contents($this->path);
        # ast - abstract syntax tree
        $this->ast = $this->parse();
    }

    static function load($relativePath)
    {
        return new PSRFile(
            $relativePath
        );
    }

    /* API **********************************/

    public function path()
    {
        return $this->path;
    }

    public function relativePath($newRelativePath = false)
    {
        if($newRelativePath) {
            $this->path = base_path($newRelativePath);
            $this->relativePath = $newRelativePath;
        }

        return $this->relativePath;
    }    

    public function contents()
    {
        return $this->contents;
    }

    public function namespace($newNamespace = false)
    {
        return $newNamespace ? $this->setNamespace($newNamespace) : $this->getNamespace();
    }

    public function removeNamespace()
    {
        $namespace = (new NodeFinder)->findFirstInstanceOf($this->ast, Namespace_::class);
        if($namespace) {
            $this->ast = $namespace->stmts;
        }

        return $this;
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
                    $node->stmts = array_merge($node->stmts, $this->classMethodStatements);
                }
            }
        });

        $this->ast = $traverser->traverse($this->ast);

        return $this;
    }

    public function save($path = false)
    {
        // optionally update path
        if($path) $this->path = $path;

        // write current ast to file
        $prettyPrinter = new PSR2PrettyPrinter;
        $code = $prettyPrinter->prettyPrintFile($this->ast);
        file_put_contents($this->path,$code);

        return $this;
    }
    
    public function preview()
    {
        Storage::put(".preview/$this->relativePath", $this->print());
        return $this;
    }

    /* PRIVATE *******************************************/

    public function ast()
    {
        return $this->ast;
    }   

    private function getNamespace()
    {
        $namespace = (new NodeFinder)->findFirstInstanceOf($this->ast, Namespace_::class);
        return $namespace ? implode('\\', $namespace->name->parts) : null;
    }

    private function setNamespace($newNamespace)
    {
        $namespace = (new NodeFinder)->findFirstInstanceOf($this->ast, Namespace_::class);
        
        if($namespace) {
            // Modifying existing namespace
            $namespace->name->parts = explode("\\", $newNamespace);
        } else {
            // Add a namespace
            array_unshift(
                $this->ast,
                (new BuilderFactory)->namespace($newNamespace)->getNode()
            );
        }
        
        return $this;
        
    }    

    private function getUseStatements()
    {
        return collect((new NodeFinder)->findInstanceOf($this->ast, Node\Stmt\Use_::class))
            ->map(function($useStatement) {
                return collect($useStatement->uses)->map(function($useStatement) {
                    $base = join('\\', $useStatement->name->parts); 
                    return $base . ($useStatement->alias ? ' as ' . $useStatement->alias : '');
                });
            })->flatten()->toArray();
    }

    public function addUseStatements($newUseStatements)
    {
        $namespace = (new NodeFinder)->findFirstInstanceOf($this->ast, Namespace_::class);
        $traverser = new NodeTraverser();
        $visitor = new UseStatementInserter(
            $namespace ? $this->ast[0]->stmts : $this->ast,
            $newUseStatements);
        $traverser->addVisitor($visitor);

        $this->ast = $traverser->traverse(
            $namespace ? $this->ast[0]->stmts : $this->ast
        );

        return $this;
    }
    
    private function setUseStatements($newUseStatements)
    {
        $traverser = new NodeTraverser();
        $visitor = new UseStatementInserter($this->ast, $newUseStatements);
        $traverser->addVisitor($visitor);

        $this->ast = $traverser->traverse($this->ast);

        return $this;
    }    

    private function getClassName()
    {
        $className = (new NodeFinder)->findFirstInstanceOf($this->ast, Node\Stmt\Class_::class);
        return $className ? $className->name->name : null;        
    }

    private function setClassName($newClassName)
    {
        $class = (new NodeFinder)->findFirstInstanceOf($this->ast, Node\Stmt\Class_::class);
        
        if($class) {
            $class->name->name = $newClassName;
        }

        return $this;
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
        return $prettyPrinter->prettyPrintFile($this->ast);
    }
}