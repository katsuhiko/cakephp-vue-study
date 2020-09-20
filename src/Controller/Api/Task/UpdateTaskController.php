<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Adapter\TransactionAdapter;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cake\Utility\Hash;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\UpdateTask;

/**
 * UpdateTaskController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class UpdateTaskController extends AppController
{
    /**
     * @OA\Put(
     *   path="/api/ca-task/update/{id}.json",
     *   tags={"CaTask"},
     *   summary="タスクを更新する",
     *   @OA\Parameter(ref="#/components/parameters/UpdateTaskRequestForm_id"),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequestForm"),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/UpdateTaskResponseForm",
     *   ),
     *   @OA\Response(
     *     response="403",
     *     ref="#/components/responses/ValidationErrorResponseForm",
     *   ),
     * )
     * @param string $id id
     * @return void
     */
    public function execute(string $id): void
    {
        $requestForm = new UpdateTaskRequestForm();
        if (!$requestForm->execute(Hash::merge($this->request->getData(), ['id' => $id]))) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $adapter = new UpdateTaskAdapter();
        $transaction = new TransactionAdapter();
        $useCase = new UpdateTask($adapter, $transaction);
        $task = $useCase->execute(TaskId::of($requestForm->id()), $requestForm->description());

        $responseForm = new UpdateTaskResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}
