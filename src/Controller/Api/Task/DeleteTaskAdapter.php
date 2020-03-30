<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\DeleteTaskCommandPort;

class DeleteTaskAdapter implements DeleteTaskCommandPort
{
    use LocatorAwareTrait;

    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @return \Cas\Domain\Model\Task|null
     */
    public function delete(TaskId $id): ?Task
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        /** @var \App\Model\Entity\Task|null $task */
        $task = $Tasks->find()->where(['id' => $id->asString()])->first();
        if (is_null($task)) {
            return null;
        }

        if (!$Tasks->delete($task)) {
            return null;
        }

        return $task->toModel();
    }
}