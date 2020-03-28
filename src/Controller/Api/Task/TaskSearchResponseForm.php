<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Collection\Collection;
use Cake\Controller\Controller;
use Cake\Form\Form;
use Cake\Validation\Validator;

/**
 * TaskSearchResponseForm
 *
 * @OA\Response(
 *   response="TaskSearchResponseForm",
 *   description="OK",
 *   @OA\JsonContent(
 *     type="object",
 *     @OA\Property(
 *       property="tasks",
 *       type="array",
 *       description="タスク一覧",
 *       @OA\Items(ref="#/components/schemas/TaskDetailForm"),
 *     ),
 *   ),
 * )
 *
 * @OA\Schema(
 *   description="タスク検索レスポンス情報",
 *   type="object",
 * )
 */
class TaskSearchResponseForm extends Form
{
    /**
     * @OA\Property(
     *   property="tasks",
     *   type="array",
     *   description="tasks",
     *   @OA\Items(ref="#/components/schemas/TaskDetailForm"),
     * )
     *
     * @var array<\App\Controller\Api\Task\TaskDetailForm>
     */
    private $data = [];

    /**
     * @param \Cake\Validation\Validator $validator Validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $taskValidator = (new TaskDetailForm())->validationDefault(new Validator());
        $validator->addNestedMany('tasks', $taskValidator);

        return $validator;
    }

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->data = (new Collection($data['tasks']))->map(function ($task) {
            $taskDetail = new TaskDetailForm();
            $taskDetail->execute($task);

            return $taskDetail;
        })->toArray();

        return true;
    }

    /**
     * @param \Cake\Controller\Controller $controller controller
     * @return void
     */
    public function response(Controller $controller): void
    {
        $controller->set('data', $this->data);
        $controller->viewBuilder()->setOption('serialize', ['data']);
    }
}
