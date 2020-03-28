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
     * @OA\Get(
     *   path="/api/task/search.json",
     *   tags={"Task"},
     *   summary="タスクを検索する",
     *   @OA\Parameter(
     *     name="description_like",
     *     in="query",
     *     required=false,
     *     description="タスク内容検索条件",
     *     @OA\Schema(type="string"),
     *     example="作業"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="tasks",
     *         type="array",
     *         description="タスク一覧",
     *         @OA\Items(
     *           @OA\Property(
     *             property="id",
     *             type="string",
     *             description="タスクID",
     *           ),
     *           @OA\Property(
     *             property="description",
     *             type="string",
     *             description="タスク内容",
     *           ),
     *         ),
     *         example={
     *           {
     *             "id"="c366f5be-360b-45cc-8282-65c80e434f72",
     *             "description"="朝の身だしなみチェック",
     *           },
     *           {
     *             "id"="93d5ef90-be4d-4179-9311-e39bddc26427",
     *             "description"="寝る前の作業",
     *           },
     *         },
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *     ),
     *   ),
     * )
     *
     * @return void
     */
    public function search(): void
    {
        $this->loadModel('Tasks');
        $descriptionLike = strval($this->request->getQuery('description_like'));

        $query = $this->Tasks->find();
        if ($descriptionLike) {
            $query = $query->where(['description LIKE' => "%{$descriptionLike}%"]);
        }
        $tasks = $query->all();

        $this->set('tasks', $tasks);
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }

    /**
     * Detail method
     *
     * @OA\Get(
     *   path="/api/task/detail/{id}.json",
     *   tags={"Task"},
     *   summary="タスクを参照する",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="タスクID",
     *     @OA\Schema(type="string"),
     *     example="c366f5be-360b-45cc-8282-65c80e434f72"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="task",
     *         type="object",
     *         description="タスク",
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *           description="ID",
     *           example="c366f5be-360b-45cc-8282-65c80e434f72",
     *         ),
     *         @OA\Property(
     *           property="description",
     *           type="string",
     *           description="タスク内容",
     *           example="朝の身だしなみチェック",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *     ),
     *   ),
     * )
     *
     * @param string $id id
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
     * @OA\Post(
     *   path="/api/task/create.json",
     *   tags={"Task"},
     *   summary="タスクを登録する",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"description"},
     *       @OA\Property(
     *         property="description",
     *         type="string",
     *         description="タスク内容",
     *         example="朝の身だしなみチェック",
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="task",
     *         type="object",
     *         description="タスク",
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *           description="ID",
     *           example="c366f5be-360b-45cc-8282-65c80e434f72",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *     ),
     *   ),
     * )
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
     * @OA\Put(
     *   path="/api/task/update/{id}.json",
     *   tags={"Task"},
     *   summary="タスクを更新する",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="タスクID",
     *     @OA\Schema(type="string"),
     *     example="c366f5be-360b-45cc-8282-65c80e434f72"
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"description"},
     *       @OA\Property(
     *         property="description",
     *         type="string",
     *         description="タスク内容",
     *         example="朝の身だしなみチェック",
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="task",
     *         type="object",
     *         description="タスク",
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *           description="ID",
     *           example="c366f5be-360b-45cc-8282-65c80e434f72",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *     ),
     *   ),
     * )
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
     * @OA\Delete(
     *   path="/api/task/delete/{id}.json",
     *   tags={"Task"},
     *   summary="タスクを削除する",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="タスクID",
     *     @OA\Schema(type="string"),
     *     example="c366f5be-360b-45cc-8282-65c80e434f72"
     *   ),
     *   @OA\Response(
     *     response=204,
     *     description="No Content",
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *     ),
     *   ),
     * )
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
