<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Collection\Collection;
use Cake\Controller\Controller;
use Cake\Form\Form;

/**
 * SearchTaskResponseForm
 *
 * @OA\Response(
 *   response="SearchTaskResponseForm",
 *   description="OK",
 *   @OA\JsonContent(ref="#/components/schemas/SearchTaskResponseForm"),
 * )
 *
 * @OA\Schema(
 *   description="タスク検索レスポンス情報",
 *   type="object",
 * )
 */
class SearchTaskResponseForm extends Form
{
    /**
     * @OA\Property(
     *   property="data",
     *   type="array",
     *   description="タスク一覧情報",
     *   @OA\Items(ref="#/components/schemas/TaskDetailForm"),
     * )
     *
     * @var \App\Controller\Api\Task\TaskDetailForm[]
     */
    private $data;

    // /**
    //  * @param \Cake\Validation\Validator $validator Validator
    //  * @return \Cake\Validation\Validator
    //  */
    // public function validationDefault(Validator $validator): Validator
    // {
    //     $taskValidator = (new TaskDetailForm())->validationDefault(new Validator());
    //     $validator->addNestedMany('tasks', $taskValidator);
    //     return $validator;
    // }

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
        })->toList();

        return true;
    }

    /**
     * @param \Cake\Controller\Controller $controller controller
     * @return void
     */
    public function response(Controller $controller): void
    {
        $data = (new Collection($this->data))->map(function ($taskDetail) {
            return $taskDetail->toArray();
        })->toList();

        $controller->set('data', $data);
        $controller->viewBuilder()->setOption('serialize', ['data']);
    }
}
