<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ApplicationErrorResponseForm;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;

/**
 * TaskCreateController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TaskCreateController extends AppController
{
    /**
     * @OA\Post(
     *   path="/api/ca-task/create.json",
     *   tags={"CaTask"},
     *   summary="タスクを登録する",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/TaskCreateRequestForm"),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/TaskCreateResponseForm",
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
    public function execute(): void
    {
        $requestForm = new TaskCreateRequestForm();
        if (!$requestForm->execute($this->request->getData())) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $this->loadModel('Tasks');
        $task = $this->Tasks->newEntity($requestForm->data());
        if ($task->hasErrors()) {
            ApplicationErrorResponseForm::error($this, $task->getErrors());

            return;
        }

        if (!$this->Tasks->save($task)) {
            ApplicationErrorResponseForm::error($this, ['save' => __('登録できませんでした。')]);

            return;
        }

        $responseForm = new TaskCreateResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}
