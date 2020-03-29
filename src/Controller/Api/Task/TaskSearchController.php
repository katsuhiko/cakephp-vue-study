<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cake\Collection\Collection;
use Cas\UseCase\Task\TaskSearch;

/**
 * TaskSearchController
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
     * )
     *
     * @return void
     */
    public function execute(): void
    {
        $requestForm = new TaskSearchRequestForm();
        if (!$requestForm->execute($this->request->getQuery())) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $adapter = new TaskSearchAdapter();
        $useCase = new TaskSearch($adapter);
        $taskModels = $useCase->execute($requestForm->descriptionLike());

        $tasks = (new Collection($taskModels))->map(function ($taskModel) {
            return $taskModel->toArray();
        })->toList();

        $responseForm = new TaskSearchResponseForm();
        // if (!$responseForm->execute(['tasks' => $tasks])) {
        //     ApplicationErrorResponseForm::error($this, $responseForm->getErrors());
        //     return;
        // }
        $responseForm->execute(['tasks' => $tasks]);
        $responseForm->response($this);
    }
}
