<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Model\Task;

interface UpdateTaskCommandPort
{
    /**
     * @param \Cas\Domain\Model\Task $task task
     * @return \Cas\Domain\Model\Task
     */
    public function update(Task $task): Task;
}
