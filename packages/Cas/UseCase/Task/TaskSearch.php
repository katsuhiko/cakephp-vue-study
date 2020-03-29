<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

/**
 * TaskSearch
 */
class TaskSearch
{
    /**
     * @var \Cas\UseCase\Task\TaskSearchQueryPort
     */
    private $query;

    /**
     * @param \Cas\UseCase\Task\TaskSearchQueryPort $query query
     */
    public function __construct(TaskSearchQueryPort $query)
    {
        $this->query = $query;
    }

    /**
     * @param string $descriptionLike descriptionLike
     * @return \Cas\Domain\Model\Task[]
     */
    public function execute(string $descriptionLike)
    {
        return $this->query->findTasks($descriptionLike);
    }
}
