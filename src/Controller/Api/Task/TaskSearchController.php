<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ApplicationErrorResponseForm;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;

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
     *   tags={"CaTask"},
     *   summary="タスクを検索する",
     *   @OA\Parameter(ref="#/components/parameters/TaskSearchRequestForm_descriptionLike"),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/TaskSearchResponseForm",
     *   ),
     *   @OA\Response(
     *     response="403",
     *     ref="#/components/responses/ValidationErrorResponseForm",
     *   ),
     *   @OA\Response(
     *     response="500",
     *     ref="#/components/responses/ApplicationErrorResponseForm",
     *   ),
     * )
     *
     * @return void
     */
    public function index(): void
    {
        $requestForm = new TaskSearchRequestForm();
        if (!$requestForm->execute($this->request->getQuery())) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $this->loadModel('Tasks');
        $query = $this->Tasks->find();
        if (!is_null($requestForm->descriptionLike())) {
            $query->where(['description LIKE' => "%{$requestForm->descriptionLike()}%"]);
        }
        $tasks = $query->enableHydration(false)->toArray();

        $responseForm = new TaskSearchResponseForm();
        if (!$responseForm->execute(['tasks' => $tasks])) {
            ApplicationErrorResponseForm::error($this, $responseForm->getErrors());

            return;
        }

        $responseForm->response($this);
    }
}
