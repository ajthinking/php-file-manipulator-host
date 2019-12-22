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

class UseStatementInserter extends NodeVisitorAbstract {
    public function __construct($root, $newUseStatements)
    {
        $this->ast = $root;
        $this->newUseStatements = $newUseStatements;
        $this->useCount = $this->useCount();
        $this->currentUseIndex = 0;
    }

    public function beforeTraverse(array $nodes) {
        //
    }

    public function afterTraverse(array $nodes) {
        if(!$this->useCount) {
            array_unshift(
                $nodes,
                (new BuilderFactory)->use($this->newUseStatements[0])->getNode()
            );            
        }

        return $nodes;
    }    

    public function leaveNode(Node $node) {
        if ($node instanceof Use_) $this->currentUseIndex++;

        if ($this->currentUseIndex == $this->useCount && $node instanceof Use_) {
            $newUseNodes = collect($this->newUseStatements)->map(function($newUseStatement) {
                return (new BuilderFactory)->use($newUseStatement)->getNode();
            });

            return collect([$node])->concat($newUseNodes)->toArray();
        }
    }    

    private function useCount()
    {
        return collect((new NodeFinder)->findInstanceOf($this->ast, Node\Stmt\Use_::class))->count();        
    }

}