# PHP-FILE-MANIPULATOR
Programatically manipulate PHP / Laravel files on disk with an intuiutive, fluent API.

## Installation
```
composer require ajthinking/php-file-manipulator
```

## Examples

### 
```php

// list class methods
PHPFile::load('app/User.php')
    ->classMethods()

// move User.php to a Models directory
PHPFile::load('app/User.php')
    ->namespace('App\Models')
    ->move('app/Models/User.php')

// install a package trait
PHPFile::load('app/User.php')
    ->addUseStatements('Package\Tool')
    ->addTraitUseStatement('Tool')
    ->save()

// find files with the query builder
PHPFile::in('database/migrations')
    ->where('classExtends', 'Migration')
    ->get()
    ->each(function($file) {
        echo $file->className()
    });

// add relationship methods
LaravelFile::load('app/User.php')
    ->addHasMany('App\Car')
    ->addHasOne('App\Life')
    ->addBelongsTo('App\Wife')
    ->save()

// add a route
LaravelFile::load('routes/web.php')
    ->addRoute('dummy', 'Controller@method')
    ->save()
    
// preview will write result relative to storage/.preview
LaravelFile::load('app/User.php')
    ->setClassName('Mistake')
    ->preview()

// add items to protected properties
LaravelFile::load('app/User.php')
    ->addFillable('message')
    ->addCasts(['is_admin' => 'boolean'])
    ->addHidden('secret')    

```

## Running tests
```bash
# the test suite requires that you have the package installed in a laravel project
vendor/phpunit/phpunit/phpunit packages/Ajthinking/PHPFileManipulator/tests
```

## License
MIT

## Contributing
PRs and issues are welcome. 

## TODO


| task | status |
|------|--------|
| expose method for custom actions | - |
| Strategy for method resources| - |
| Make the test work without being inside a host application| - |
| Create a dedicated Storage disk (storage/php-file-manipulator/preview etc) | - |
| Solve difference for namespaced and not namespaced files | - |
| it_can_add_use_statements_with_alias | - |
| `GroupUse`, example:  `use Package\{Alfa, Beta};` | - |
| how handle base_path() when not in a Laravel app? | - |
| fix addHasManyMethod to accept array instead of string | - |
| simplify adding multiline docblocks | - |

## API status


| resource       | get| set | add | remove |
|----------------|----|-----|-----|--------|
| namespace      | X  | X   | N/A | X      |
| namespaceNS    | X  | X   | N/A | X      |
| useStatements  | X  | X   | X   | -      |
| useStatements0U|  - | -   | -   | -      |
| className      |  - | -   | -   | -      |
| classExtends   |  - | -   | -   | -      |
| classImplements|  - | -   | -   | -      |
| traits         |  - | -   | -   | -      |
| properties     |  - | -   | -   | -      |
| methods        |  - | -   | -   | -      |


## Acknowledgements
* Built almost entirely with [nikic/php-parser](https://github.com/nikic/php-parser)
* PSR Printing fixes borrowed from [tcopestake/PHP-Parser-PSR-2-pretty-printer](https://github.com/tcopestake/PHP-Parser-PSR-2-pretty-printer)

## Stay tuned!
Follow me on twitter: [@ajthinking](https://twitter.com/ajthinking)

<a href="https://www.patreon.com/ajthinking" >Help me continue this work | Patreon</a>