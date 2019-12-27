<?php

namespace Ajthinking\PHPFileManipulator;

use Ajthinking\PHPFileManipulator\Traits\DelegatesAPICalls;
use Ajthinking\PHPFileManipulator\Traits\HasIO;
use Ajthinking\PHPFileManipulator\Traits\HasQueryBuilder;

class PHPFile
{
    use DelegatesAPICalls;
    use HasIO;
    use HasQueryBuilder;
    
    protected $resources = [
        'namespace',
        'uses',
        'className',
        'classExtends',
        'classImplements',
        // 'classUseTraits',
        // 'classConst',
        // 'classMethods',
        // 'classMethodNames',
    ];
}