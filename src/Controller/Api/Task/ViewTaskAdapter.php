<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Exception\DomainNotFoundException;
use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\ViewTaskQueryPort;

class ViewTaskAdapter implements ViewTaskQueryPort
{
    use LocatorAwareTrait;

    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @return \Cas\Domain\Model\Task
     */
    public function findTask(TaskId $id): Task
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        /** @var \App\Model\Entity\Task|null $task */
        $task = $Tasks->find()->where(['id' => $id->asString()])->first();
        if (is_null($task)) {
            throw new DomainNotFoundException("参照する情報がありませんでした。 task id={$id->asString()}");
        }

        return $task->toModel();
    }
}
