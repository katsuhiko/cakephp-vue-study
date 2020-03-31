<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;

/**
 * ViewTask
 */
class ViewTask
{
    /**
     * @var \Cas\UseCase\Task\ViewTaskQueryPort
     */
    private $query;

    /**
     * @param \Cas\UseCase\Task\ViewTaskQueryPort $query query
     */
    public function __construct(ViewTaskQueryPort $query)
    {
        $this->query = $query;
    }

    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @return \Cas\Domain\Model\Task
     */
    public function execute(TaskId $id): Task
    {
        return $this->query->findTask($id);
    }
}
