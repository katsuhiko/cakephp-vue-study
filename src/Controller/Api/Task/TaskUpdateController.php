<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ApplicationErrorResponseForm;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * TaskUpdateController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TaskUpdateController extends AppController
{
    /**
     * @OA\Put(
     *   path="/api/ca-task/update/{id}.json",
     *   tags={"CaTask"},
     *   summary="タスクを更新する",
     *   @OA\Parameter(ref="#/components/parameters/TaskUpdateRequestForm_id"),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/TaskUpdateRequestForm"),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/TaskUpdateResponseForm",
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
     * @param string $id id
     * @return void
     */
    public function index($id): void
    {
        $requestForm = new TaskUpdateRequestForm();
        if (!$requestForm->execute(Hash::merge($this->request->getData(), ['id' => $id]))) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $this->loadModel('Tasks');
        $task = $this->Tasks->get($requestForm->id());
        $task = $this->Tasks->patchEntity($task, $requestForm->data());
        if ($task->hasErrors()) {
            ApplicationErrorResponseForm::error($this, $task->getErrors());

            return;
        }

        if (!$this->Tasks->save($task)) {
            ApplicationErrorResponseForm::error($this, ['save' => __('更新できませんでした。')]);

            return;
        }

        $responseForm = new TaskUpdateResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}