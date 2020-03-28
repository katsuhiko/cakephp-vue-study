<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Collection\Collection;
use Cake\Form\Form;
use Cake\Validation\Validator;

/**
 * TaskSearch ResponseForm
 */
class TaskSearchResponseForm extends Form
{
    /**
     * @OA\Response(
     *   response="TaskSearchResponseForm",
     *   description="OK",
     *   @OA\JsonContent(
     *     type="object",
     *     @OA\Property(
     *       property="tasks",
     *       type="array",
     *       description="タスク一覧",
     *       @OA\Items(
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *           description="タスクID",
     *         ),
     *         @OA\Property(
     *           property="description",
     *           type="string",
     *           description="タスク内容",
     *         ),
     *       ),
     *       example={
     *         {
     *           "id"="c366f5be-360b-45cc-8282-65c80e434f72",
     *           "description"="朝の身だしなみチェック",
     *         },
     *         {
     *           "id"="93d5ef90-be4d-4179-9311-e39bddc26427",
     *           "description"="寝る前の作業",
     *         },
     *       },
     *     ),
     *   ),
     * )
     *
     * @var array
     */
    public $data = [];

    /**
     * @param \Cake\Validation\Validator $validator Validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $taskValidator = new Validator();

        $taskValidator
            ->uuid('id')
            ->requirePresence('id')
            ->notEmptyString('id');

        $taskValidator
            ->scalar('description')
            ->requirePresence('description')
            ->allowEmptyString('description');

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
            return [
                'id' => $task['id'],
                'description' => $task['description'],
            ];
        })->toArray();

        return true;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }
}
