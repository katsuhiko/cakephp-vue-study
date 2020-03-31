<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Exception\DomainArgumentException;
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

        /** @var \App\Model\Entity\Task|null $old */
        $old = $Tasks->find()->where(['id' => $id->asString()])->first();
        if (is_null($old)) {
            throw new DomainNotFoundException("更新する情報がありませんでした。 task id={$id->asString()}");
        }

        /** @var \App\Model\Entity\Task $task */
        $task = $Tasks->patchEntity($old, [
            'description' => $description,
        ]);
        if ($task->hasErrors()) {
            throw new DomainArgumentException("更新時の引数が不正です。 task description={$description}");
        }

        if (!$Tasks->save($task)) {
            throw new DomainSystemException("更新できませんでした。 task id={$id->asString()}");
        }

        return $task->toModel();
    }
}
