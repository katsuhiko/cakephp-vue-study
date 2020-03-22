<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Exception\ApplicationException;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    /**
     * @return void
     */
    public function search(): void
    {
        $tasks = $this->Tasks->find()->all();

        $this->set('tasks', $tasks);
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }

    /**
     * @param string $id id
     * @return void
     */
    public function detail(string $id): void
    {
        $task = $this->Tasks->get($id);

        $this->set('task', $task);
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $data = $this->request->getData();

        $task = $this->Tasks->newEntity($data);
        if ($task->hasErrors()) {
            $this->set('errors', $task->getErrors());
            $this->viewBuilder()->setOption('serialize', ['errors']);

            return;
        }

        if (!$this->Tasks->save($task)) {
            throw new ApplicationException(__('登録できませんでした。'));
        }

        $this->set('task', ['id' => $task->id]);
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * @param string $id id
     * @return void
     */
    public function update(string $id): void
    {
        $data = $this->request->getData();
        $task = $this->Tasks->get($id);

        $task = $this->Tasks->patchEntity($task, $data);
        if ($task->hasErrors()) {
            $this->set('errors', $task->getErrors());
            $this->viewBuilder()->setOption('serialize', ['errors']);

            return;
        }

        if (!$this->Tasks->save($task)) {
            throw new ApplicationException(__('更新できませんでした。'));
        }

        $this->set('task', ['id' => $id]);
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * @param string $id id
     * @return void
     */
    public function delete(string $id): void
    {
        $task = $this->Tasks->get($id);

        if (!$this->Tasks->delete($task)) {
            throw new ApplicationException(__('削除できませんでした。'));
        }

        $this->response = $this->response->withStatus(204);
        $this->viewBuilder()->setOption('serialize', []);
    }
}
