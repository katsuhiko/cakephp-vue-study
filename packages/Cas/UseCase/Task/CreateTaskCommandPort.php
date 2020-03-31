<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Model\Task;

interface CreateTaskCommandPort
{
    /**
     * @param \Cas\Domain\Model\Task $task task
     * @return \Cas\Domain\Model\Task
     */
    public function create(Task $task): Task;
}
