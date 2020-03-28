<?php
declare(strict_types=1);

namespace App\Exception;

use Cake\Core\Exception\Exception;

class RequestValidationException extends Exception
{
    /**
     * @var int
     */
    protected $_defaultCode = 400;

    /**
     * @var string
     */
    protected $_messageTemplate = 'Invlid Parameter';
}
