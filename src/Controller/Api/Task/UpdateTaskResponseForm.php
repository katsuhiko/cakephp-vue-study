<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Controller\Controller;
use Cake\Form\Form;

/**
 * UpdateTaskResponseForm
 *
 * @OA\Response(
 *   response="UpdateTaskResponseForm",
 *   description="OK",
 *   @OA\JsonContent(ref="#/components/schemas/UpdateTaskResponseForm"),
 * )
 * @OA\Schema(
 *   description="タスク更新レスポンス情報",
 *   type="object",
 * )
 */
class UpdateTaskResponseForm extends Form
{
    /**
     * @OA\Property(
     *   property="data",
     *   type="object",
     *   description="タスクID情報",
     *   ref="#/components/schemas/TaskIdForm",
     * )
     * @var \App\Controller\Api\Task\TaskIdForm
     */
    private $id;

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->id = new TaskIdForm();
        $this->id->execute($data['task']);

        return true;
    }

    /**
     * @param \Cake\Controller\Controller $controller controller
     * @return void
     */
    public function response(Controller $controller): void
    {
        $data = $this->id->toArray();

        $controller->set('data', $data);
        $controller->viewBuilder()->setOption('serialize', ['data']);
    }
}
