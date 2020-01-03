<?php

namespace Ajthinking\PHPFileManipulator;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Arg;
use PhpParser\BuilderFactory;

use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Name;
use Illuminate\Support\Str;

class LaravelSnippet
{
    public static function hasManyMethod($target, $docComment = false)
    {
        $methodName = Str::camel(
            Str::plural(
                collect(explode('\\', $target))->last()
            )
        );

        $factory = new BuilderFactory;

        return $factory->method($methodName)
            ->addStmt(
                new Return_(
                    new MethodCall(
                        new Variable('this'),
                        'hasMany',
                        [
                            new Arg(
                                new ClassConstFetch(
                                    new Name($target),
                                    'class'
                                )
                            )
                        ]
                    )
                )
            )
            ->setDocComment(
                $docComment ? $docComment : 
                "/**
                * Get the associated $methodName
                */"
            )
            ->getNode();        
    }
}