<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\TransactionPort;

/**
 * DeleteTask
 */
class DeleteTask
{
    /**
     * @var \Cas\UseCase\Task\DeleteTaskCommandPort
     */
    private $command;

    /**
     * @var \Cas\UseCase\TransactionPort
     */
    private $transaction;

    /**
     * @param \Cas\UseCase\Task\DeleteTaskCommandPort $command command
     * @param \Cas\UseCase\TransactionPort $transaction transaction
     */
    public function __construct(DeleteTaskCommandPort $command, TransactionPort $transaction)
    {
        $this->command = $command;
        $this->transaction = $transaction;
    }

    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @return \Cas\Domain\Model\Task
     */
    public function execute(TaskId $id): Task
    {
        return $this->transaction->transactional(function () use ($id) {
            return $this->command->delete($id);
        });
    }
}
