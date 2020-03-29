<?php
declare(strict_types=1);

namespace App\Adapter;

use Cake\Datasource\ConnectionManager;
use Cas\UseCase\TransactionPort;

/**
 * TransactionAdapter
 */
class TransactionAdapter implements TransactionPort
{
    /**
     * @param callable $callback callback
     * @return mixed
     */
    public function transactional(callable $callback)
    {
        $connection = ConnectionManager::get('default');

        return $connection->transactional($callback);
    }
}
