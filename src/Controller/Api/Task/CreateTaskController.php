<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Adapter\TransactionAdapter;
use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cas\UseCase\Task\CreateTask;

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
     * )
     * @return void
     */
    public function execute(): void
    {
        $requestForm = new CreateTaskRequestForm();
        if (!$requestForm->execute($this->request->getData())) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $adapter = new CreateTaskAdapter();
        $transaction = new TransactionAdapter();
        $useCase = new CreateTask($adapter, $transaction);
        $task = $useCase->execute($requestForm->description());

        $responseForm = new CreateTaskResponseForm();
        $responseForm->execute(['task' => $task->toArray()]);
        $responseForm->response($this);
    }
}
