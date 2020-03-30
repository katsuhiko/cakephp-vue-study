<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Model\Task;
use Cas\UseCase\Task\CreateTaskCommandPort;

class CreateTaskAdapter implements CreateTaskCommandPort
{
    use LocatorAwareTrait;

    /**
     * @param string $description description
     * @return \Cas\Domain\Model\Task|null
     */
    public function create(string $description): ?Task
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        /** @var \App\Model\Entity\Task $task */
        $task = $Tasks->newEntity([
            'description' => $description,
        ]);
        if ($task->hasErrors()) {
            return null;
        }

        if (!$Tasks->save($task)) {
            return null;
        }

        return $task->toModel();
    }
}
