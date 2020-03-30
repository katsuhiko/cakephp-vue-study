<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

/**
 * SearchTask
 */
class SearchTask
{
    /**
     * @var \Cas\UseCase\Task\SearchTaskQueryPort
     */
    private $query;

    /**
     * @param \Cas\UseCase\Task\SearchTaskQueryPort $query query
     */
    public function __construct(SearchTaskQueryPort $query)
    {
        $this->query = $query;
    }

    /**
     * @param string|null $descriptionLike descriptionLike
     * @return \Cas\Domain\Model\Task[]
     */
    public function execute(?string $descriptionLike): array
    {
        return $this->query->findTasks($descriptionLike);
    }
}
