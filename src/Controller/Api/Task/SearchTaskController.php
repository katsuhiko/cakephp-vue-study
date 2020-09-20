<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cake\Collection\Collection;
use Cas\UseCase\Task\SearchTask;

/**
 * SearchTaskController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class SearchTaskController extends AppController
{
    /**
     * @OA\Get(
     *   path="/api/ca-task/search.json",
     *   tags={"CaTask"},
     *   summary="タスクを検索する",
     *   @OA\Parameter(ref="#/components/parameters/SearchTaskRequestForm_descriptionLike"),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/SearchTaskResponseForm",
     *   ),
     *   @OA\Response(
     *     response="403",
     *     ref="#/components/responses/ValidationErrorResponseForm",
     *   ),
     * )
     * @return void
     */
    public function execute(): void
    {
        $requestForm = new SearchTaskRequestForm();
        if (!$requestForm->execute($this->request->getQuery())) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $adapter = new SearchTaskAdapter();
        $useCase = new SearchTask($adapter);
        $taskModels = $useCase->execute($requestForm->descriptionLike());

        $tasks = (new Collection($taskModels))->map(function ($taskModel) {
            return $taskModel->toArray();
        })->toList();

        $responseForm = new SearchTaskResponseForm();
        // if (!$responseForm->execute(['tasks' => $tasks])) {
        //     ApplicationErrorResponseForm::error($this, $responseForm->getErrors());
        //     return;
        // }
        $responseForm->execute(['tasks' => $tasks]);
        $responseForm->response($this);
    }
}
