<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Adapter\TransactionAdapter;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\DeleteTask;

/**
 * DeleteTaskController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class DeleteTaskController extends AppController
{
    /**
     * @OA\Delete(
     *   path="/api/ca-task/delete/{id}.json",
     *   tags={"CaTask"},
     *   summary="タスクを削除する",
     *   @OA\Parameter(ref="#/components/parameters/DeleteTaskRequestForm_id"),
     *   @OA\Response(
     *     response="204",
     *     ref="#/components/responses/DeleteTaskResponseForm",
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
    public function execute(string $id): void
    {
        $requestForm = new DeleteTaskRequestForm();
        if (!$requestForm->execute(['id' => $id])) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $adapter = new DeleteTaskAdapter();
        $transaction = new TransactionAdapter();
        $useCase = new DeleteTask($adapter, $transaction);
        $task = $useCase->execute(TaskId::of($requestForm->id()));

        $responseForm = new DeleteTaskResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}
