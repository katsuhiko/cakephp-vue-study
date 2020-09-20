<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Exception\DomainSystemException;
use Cas\Domain\Model\Task;
use Cas\UseCase\Task\CreateTaskCommandPort;

class CreateTaskAdapter implements CreateTaskCommandPort
{
    use LocatorAwareTrait;

    /**
     * @param \Cas\Domain\Model\Task $task task
     * @return \Cas\Domain\Model\Task
     */
    public function create(Task $task): Task
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        /** @var \App\Model\Entity\Task $taskEntity */
        $taskEntity = $Tasks->newEmptyEntity();
        $taskArray = $task->toArray();

        $taskEntity->id = $taskArray['id'];
        $taskEntity->description = $taskArray['description'];

        if (!$Tasks->save($taskEntity, ['atomic' => false, 'checkExisting' => false])) {
            throw new DomainSystemException('登録できませんでした。');
        }

        return $taskEntity->toModel();
    }
}
