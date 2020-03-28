<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\AppController;
use App\Exception\RequestValidationException;
use App\Exception\ResponseValidationException;

/**
 * TaskSearch Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TaskSearchController extends AppController
{
    /**
     * @OA\Get(
     *   path="/api/ca-task/search.json",
     *   tags={"Task"},
     *   summary="タスクを検索する",
     *   @OA\Parameter(ref="#/components/parameters/TaskSearchRequestForm_descriptionLike"),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/TaskSearchResponseForm"),
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
    public function index(): void
    {
        $requestForm = new TaskSearchRequestForm();
        if (!$requestForm->execute($this->request->getQuery())) {
            throw new RequestValidationException($requestForm->getErrors());
        }

        $this->loadModel('Tasks');
        $query = $this->Tasks->find();
        if ($requestForm->descriptionLike()) {
            $query->where(['description LIKE' => "%{$requestForm->descriptionLike()}%"]);
        }
        $tasks = $query->enableHydration(false)->toArray();

        $responseForm = new TaskSearchResponseForm();
        if (!$responseForm->execute(['tasks' => $tasks])) {
            throw new ResponseValidationException($responseForm->getErrors());
        }

        $responseForm->response($this);
    }
}
