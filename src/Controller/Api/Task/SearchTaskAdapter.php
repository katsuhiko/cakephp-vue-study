<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Collection\Collection;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\UseCase\Task\SearchTaskQueryPort;

class SearchTaskAdapter implements SearchTaskQueryPort
{
    use LocatorAwareTrait;

    /**
     * @param string|null $descriptionLike descriptionLike
     * @return \Cas\Domain\Model\Task[]
     */
    public function findTasks(?string $descriptionLike): array
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        $query = $Tasks->find();
        if (!is_null($descriptionLike)) {
            $query->where(['description LIKE' => "%{$descriptionLike}%"]);
        }
        $tasks = $query->all();

        return (new Collection($tasks))->map(function ($task) {
            return $task->toModel();
        })->toList();
    }
}
