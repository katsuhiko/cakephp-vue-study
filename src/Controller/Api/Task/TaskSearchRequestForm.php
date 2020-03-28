<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Form\Form;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * TaskSearch RequestForm
 */
class TaskSearchRequestForm extends Form
{
    /**
     * @OA\Parameter(
     *   parameter="TaskSearchRequestForm_descriptionLike",
     *   name="description_like",
     *   in="query",
     *   required=false,
     *   description="タスク内容検索条件",
     *   @OA\Schema(type="string"),
     *   example="作業"
     * )
     *
     * @var string $descriptionLike
     */
    private $descriptionLike;

    /**
     * @param \Cake\Validation\Validator $validator Validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('description_like')
            ->requirePresence('description_like', false)
            ->allowEmptyString('description_like');

        return $validator;
    }

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $data = Hash::merge([
            'description_like' => '',
        ], $data);

        $this->descriptionLike = strval($data['description_like']);

        return true;
    }

    /**
     * @return string
     */
    public function descriptionLike(): string
    {
        return $this->descriptionLike;
    }
}
