<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * TaskDetailController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TaskDetailController extends AppController
{
    /**
     * @OA\Get(
     *   path="/api/ca-task/detail/{id}.json",
     *   tags={"CaTask"},
     *   summary="タスクを参照する",
     *   @OA\Parameter(ref="#/components/parameters/TaskDetailRequestForm_id"),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/TaskDetailResponseForm",
     *   ),
     *   @OA\Response(
     *     response="403",
     *     ref="#/components/responses/ValidationErrorResponseForm",
     *   ),
     * )
     *
     * @param string $id id
     * @return void
     */
    public function index($id): void
    {
        $requestForm = new TaskDetailRequestForm();
        if (!$requestForm->execute(Hash::merge($this->request->getData(), ['id' => $id]))) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $this->loadModel('Tasks');
        $task = $this->Tasks->get($requestForm->id());

        $responseForm = new TaskDetailResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}
