<?php

use Illuminate\Foundation\Inspiring;

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

use App\PSRManipulator\PSRFile;
use App\PSRManipulator\Stub; 
//use PSRManipulator\Laravel\Stubs\Relationships;
    

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('psr:namespace', function () {
    $this->info(
        dd(
            PSRFile::load('app/Console/Kernel.php')->namespace('BadAss\\NameSpace\\IsCool')
                ->namespace()
        )
    );
});

Artisan::command('psr:ast', function () {
    dd(
        PSRFile::load('app/User.php')->ast()
    );    
});

Artisan::command('psr:save', function () {
    PSRFile::load('app/User.php')->save('app/Benno.php');
});

Artisan::command('psr:method', function () {

    $classMethodStatements = PSRFile::load(
        'app/PSRManipulator/Stubs/Laravel/HAS_MANY.stub.php'
    )->ast()[0]->stmts;
    
    PSRFile::load('app/User.php')
        ->addClassMethod($classMethodStatements)
        ->save('app/Benno.php');
});

/*
$code = file_get_contents(app_path('User.php'));

$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
try {
    $ast = $parser->parse($code);
} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}

$traverser = new NodeTraverser();
$traverser->addVisitor(new class extends NodeVisitorAbstract {
    public function enterNode(Node $node) {
        if ($node instanceof ClassMethod) {
            // Clean out the function body
            $node->stmts = [];
            
            echo "Cleaning a class method node...";
        }
    }
});

$ast = $traverser->traverse($ast);



$dumper = new NodeDumper;


Artisan::command('parse', function () use($dumper, $ast) {
    //echo $dumper->dump($ast) . "\n";

    $prettyPrinter = new PhpParser\PrettyPrinter\Standard;
    $newCode = $prettyPrinter->prettyPrintFile($ast);

    echo $newCode;

    //$this->info("success");
});

*/