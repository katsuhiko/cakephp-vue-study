<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cas\Domain\Exception\DomainArgumentException;
use Cas\Domain\Exception\DomainSystemException;
use Cas\Domain\Model\Task;
use Cas\UseCase\Task\CreateTaskCommandPort;

class CreateTaskAdapter implements CreateTaskCommandPort
{
    use LocatorAwareTrait;

    /**
     * @param string $description description
     * @return \Cas\Domain\Model\Task
     */
    public function create(string $description): Task
    {
        $Tasks = $this->getTableLocator()->get('Tasks');

        /** @var \App\Model\Entity\Task $task */
        $task = $Tasks->newEntity([
            'description' => $description,
        ]);
        if ($task->hasErrors()) {
            throw new DomainArgumentException("登録時の引数が不正です。 task description={$description}");
        }

        $task->description = $description;

        if (!$Tasks->save($task, ['atomic' => false])) {
            throw new DomainSystemException("登録できませんでした。");
        }

        return $task->toModel();
    }
}
