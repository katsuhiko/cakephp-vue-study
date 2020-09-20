<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Controller\Controller;
use Cake\Form\Form;

/**
 * ViewTaskResponseForm
 *
 * @OA\Response(
 *   response="ViewTaskResponseForm",
 *   description="OK",
 *   @OA\JsonContent(ref="#/components/schemas/ViewTaskResponseForm"),
 * )
 * @OA\Schema(
 *   description="タスク更新レスポンス情報",
 *   type="object",
 * )
 */
class ViewTaskResponseForm extends Form
{
    /**
     * @OA\Property(
     *   property="data",
     *   type="object",
     *   description="タスク詳細情報",
     *   ref="#/components/schemas/TaskDetailForm",
     * )
     * @var \App\Controller\Api\Task\TaskDetailForm
     */
    private $data;

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->data = new TaskDetailForm();
        $this->data->execute($data['task']);

        return true;
    }

    /**
     * @param \Cake\Controller\Controller $controller controller
     * @return void
     */
    public function response(Controller $controller): void
    {
        $data = $this->data->toArray();

        $controller->set('data', $data);
        $controller->viewBuilder()->setOption('serialize', ['data']);
    }
}
