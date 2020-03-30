<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Exception\DomainException;
use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\TransactionPort;

/**
 * UpdateTask
 */
class UpdateTask
{
    /**
     * @var \Cas\UseCase\Task\UpdateTaskCommandPort
     */
    private $command;

    /**
     * @var \Cas\UseCase\TransactionPort
     */
    private $transaction;

    /**
     * @param \Cas\UseCase\Task\UpdateTaskCommandPort $command command
     * @param \Cas\UseCase\TransactionPort $transaction transaction
     */
    public function __construct(UpdateTaskCommandPort $command, TransactionPort $transaction)
    {
        $this->command = $command;
        $this->transaction = $transaction;
    }

    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @param string $description description
     * @return \Cas\Domain\Model\Task
     */
    public function execute(TaskId $id, string $description): Task
    {
        return $this->transaction->transactional(function () use ($id, $description) {
            $task = $this->command->update($id, $description);
            if (is_null($task)) {
                throw new DomainException("Update faild. task_id={$id->asString()}, description={$description}");
            }

            return $task;
        });
    }
}
