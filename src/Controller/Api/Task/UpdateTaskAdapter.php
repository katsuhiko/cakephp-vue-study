<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Exception\DomainNotFoundException;
use Cas\Domain\Exception\DomainSystemException;
use Cas\Domain\Model\Task;
use Cas\UseCase\Task\UpdateTaskCommandPort;

class UpdateTaskAdapter implements UpdateTaskCommandPort
{
    use LocatorAwareTrait;

    /**
     * @param \Cas\Domain\Model\Task $task task
     * @return \Cas\Domain\Model\Task
     */
    public function update(Task $task): Task
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        $taskArray = $task->toArray();
        /** @var \App\Model\Entity\Task|null $taskEntity */
        $taskEntity = $Tasks->find()->where(['id' => $taskArray['id']])->first();
        if (is_null($taskEntity)) {
            throw new DomainNotFoundException("更新する情報がありませんでした。 task id={$taskArray['id']}");
        }

        $taskEntity->description = $taskArray['description'];

        if (!$Tasks->save($taskEntity, ['atomic' => false])) {
            throw new DomainSystemException("更新できませんでした。 task id={$taskArray['id']}");
        }

        return $taskEntity->toModel();
    }
}
