<?php
declare(strict_types=1);

namespace Cas\UseCase;

interface TransactionPort
{
    /**
     * @param callable $callback callback
     * @return mixed
     */
    public function transactional(callable $callback);
}
