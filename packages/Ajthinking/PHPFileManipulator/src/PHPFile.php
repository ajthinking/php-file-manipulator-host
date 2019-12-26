<?php

namespace Ajthinking\PHPFileManipulator;

use Ajthinking\PHPFileManipulator\Traits\DelegatesAPICalls;
use Ajthinking\PHPFileManipulator\Traits\HasIO;

class PHPFile
{
    use DelegatesAPICalls;
    use HasIO;
    
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