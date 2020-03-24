<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Exception\ApplicationException;

/**
 * Task Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TaskController extends AppController
{
    /**
     * Search method
     * 
     * @OA\Get(
     *   path="/api/task/search",
     *   summary="タスクを検索する",
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="レスポンスボディjsonパラメータの例"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="レスポンスボディjsonパラメータの例"
     *       )
     *     )
     *   ),
     * )
     *
     * @return void
     */
    public function search(): void
    {
        $this->loadModel('Tasks');
        $tasks = $this->Tasks->find()->all();

        $this->set('tasks', $tasks);
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }

    /**
     * Detail method
     *
     * @param string $id id.
     * @return void
     */
    public function detail(string $id): void
    {
        $this->loadModel('Tasks');
        $task = $this->Tasks->get($id);

        $this->set('task', $task);
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * Create method
     *
     * @return void
     * @throws \App\Exception\ApplicationException
     */
    public function create(): void
    {
        $this->loadModel('Tasks');
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
     * Update method
     *
     * @param string $id id
     * @return void
     * @throws \App\Exception\ApplicationException
     */
    public function update(string $id): void
    {
        $this->loadModel('Tasks');
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
     * Delete method
     *
     * @param string $id id
     * @return void
     * @throws \App\Exception\ApplicationException
     */
    public function delete(string $id): void
    {
        $this->loadModel('Tasks');
        $task = $this->Tasks->get($id);

        if (!$this->Tasks->delete($task)) {
            throw new ApplicationException(__('削除できませんでした。'));
        }

        $this->response = $this->response->withStatus(204);
        $this->viewBuilder()->setOption('serialize', []);
    }
}
