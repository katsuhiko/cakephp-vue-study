<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ApplicationErrorResponseForm;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;

/**
 * TaskDeleteController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TaskDeleteController extends AppController
{
    /**
     * @OA\Delete(
     *   path="/api/ca-task/delete/{id}.json",
     *   tags={"CaTask"},
     *   summary="タスクを削除する",
     *   @OA\Parameter(ref="#/components/parameters/TaskDeleteRequestForm_id"),
     *   @OA\Response(
     *     response="204",
     *     ref="#/components/responses/TaskDeleteResponseForm",
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
    public function execute($id): void
    {
        $requestForm = new TaskDeleteRequestForm();
        if (!$requestForm->execute(['id' => $id])) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $this->loadModel('Tasks');
        $task = $this->Tasks->get($requestForm->id());
        if (!$this->Tasks->delete($task)) {
            ApplicationErrorResponseForm::error($this, ['delete' => __('削除できませんでした。')]);

            return;
        }

        $responseForm = new TaskDeleteResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}
