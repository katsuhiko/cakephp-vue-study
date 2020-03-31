<?php
declare(strict_types=1);

namespace App\Exception;

use Cake\Error\ExceptionRenderer;
use Cas\Domain\Exception\DomainNotFoundException;
use Throwable;

class ApplicationExceptionRenderer extends ExceptionRenderer
{
    /**
     * @param \Throwable $exception Exception.
     * @return int A valid HTTP error status code.
     */
    protected function _code(Throwable $exception): int
    {
        if ($exception instanceof DomainNotFoundException) {
            return 404;
        }

        return parent::_code($exception);
    }
}
