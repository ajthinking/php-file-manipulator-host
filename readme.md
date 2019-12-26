# PHP-FILE-MANIPULATOR
> Danger zone! Tools to manipulate PHP file on disk. WIP.

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
# for now im running the test from the host project root like this
vendor/phpunit/phpunit/phpunit packages/Ajthinking/PHPFileManipulator/tests
```

## TODO


| task | status |
|------|--------|
| Create a dedicated Storage disk (storage/php-file-manipulator/preview etc) | - |
| Solve difference for namespaced and not namespaced files | - |
| it_can_add_use_statements_with_alias | - |
| `GroupUse`, example:  `use Package\{Alfa, Beta};` | - |


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