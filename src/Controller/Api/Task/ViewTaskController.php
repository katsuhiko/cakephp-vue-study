<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use App\Controller\Api\ValidationErrorResponseForm;
use App\Controller\AppController;
use Cake\Utility\Hash;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\ViewTask;

/**
 * ViewTaskController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class ViewTaskController extends AppController
{
    /**
     * @OA\Get(
     *   path="/api/ca-task/view/{id}.json",
     *   tags={"CaTask"},
     *   summary="タスクを参照する",
     *   @OA\Parameter(ref="#/components/parameters/ViewTaskRequestForm_id"),
     *   @OA\Response(
     *     response="200",
     *     ref="#/components/responses/ViewTaskResponseForm",
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
        $requestForm = new ViewTaskRequestForm();
        if (!$requestForm->execute(Hash::merge($this->request->getData(), ['id' => $id]))) {
            ValidationErrorResponseForm::error($this, $requestForm->getErrors());

            return;
        }

        $adapter = new ViewTaskAdapter();
        $useCase = new ViewTask($adapter);
        $taskModel = $useCase->execute(TaskId::of($requestForm->id()));

        $responseForm = new ViewTaskResponseForm();
        $responseForm->execute(['task' => $taskModel->toArray()]);
        $responseForm->response($this);
    }
}
