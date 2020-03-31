<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;

interface DeleteTaskCommandPort
{
    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @return \Cas\Domain\Model\Task
     */
    public function delete(TaskId $id): Task;
}
