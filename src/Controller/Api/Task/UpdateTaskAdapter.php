<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Exception\DomainNotFoundException;
use Cas\Domain\Exception\DomainSystemException;
use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\UpdateTaskCommandPort;

class UpdateTaskAdapter implements UpdateTaskCommandPort
{
    use LocatorAwareTrait;

    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @param string $description description
     * @return \Cas\Domain\Model\Task
     */
    public function update(TaskId $id, string $description): Task
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        /** @var \App\Model\Entity\Task|null $task */
        $task = $Tasks->find()->where(['id' => $id->asString()])->first();
        if (is_null($task)) {
            throw new DomainNotFoundException("更新する情報がありませんでした。 task id={$id->asString()}");
        }

        $task->description = $description;

        if (!$Tasks->save($task, ['atomic' => false])) {
            throw new DomainSystemException("更新できませんでした。 task id={$id->asString()}");
        }

        return $task->toModel();
    }
}
