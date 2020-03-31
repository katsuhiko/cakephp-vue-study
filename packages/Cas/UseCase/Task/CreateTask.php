<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\TransactionPort;

/**
 * CreateTask
 */
class CreateTask
{
    /**
     * @var \Cas\UseCase\Task\CreateTaskCommandPort
     */
    private $command;

    /**
     * @var \Cas\UseCase\TransactionPort
     */
    private $transaction;

    /**
     * @param \Cas\UseCase\Task\CreateTaskCommandPort $command command
     * @param \Cas\UseCase\TransactionPort $transaction transaction
     */
    public function __construct(CreateTaskCommandPort $command, TransactionPort $transaction)
    {
        $this->command = $command;
        $this->transaction = $transaction;
    }

    /**
     * @param string $description description
     * @return \Cas\Domain\Model\Task
     */
    public function execute(string $description): Task
    {
        return $this->transaction->transactional(function () use ($description) {
            $task = new Task(TaskId::newId(), $description);

            return $this->command->create($task);
        });
    }
}
