<?php
declare(strict_types=1);

namespace App\Exception;

use Cake\Core\Exception\Exception;

class ResponseValidationException extends Exception
{
    /**
     * @var int
     */
    protected $_defaultCode = 500;

    /**
     * @var string
     */
    protected $_messageTemplate = 'Invlid Response';
}
