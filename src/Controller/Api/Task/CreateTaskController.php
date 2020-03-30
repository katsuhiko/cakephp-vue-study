<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ApplicationErrorResponseForm;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;

/**
 * CreateTaskController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class CreateTaskController extends AppController
{
    /**
     * @OA\Post(
     *   path="/api/ca-task/create.json",
     *   tags={"CaTask"},
     *   summary="タスクを登録する",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/CreateTaskRequestForm"),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/CreateTaskResponseForm",
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
        $requestForm = new CreateTaskRequestForm();
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

        $responseForm = new CreateTaskResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}
