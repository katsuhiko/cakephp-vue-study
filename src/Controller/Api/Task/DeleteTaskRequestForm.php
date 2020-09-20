<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Form\Form;
use Cake\Validation\Validator;

/**
 * DeleteTaskRequestForm
 */
class DeleteTaskRequestForm extends Form
{
    /**
     * @OA\Parameter(
     *   parameter="DeleteTaskRequestForm_id",
     *   name="id",
     *   in="path",
     *   required=true,
     *   description="タスクID",
     *   @OA\Schema(type="string"),
     *   example="c366f5be-360b-45cc-8282-65c80e434f72"
     * )
     * @var string
     */
    private $id;

    /**
     * @param \Cake\Validation\Validator $validator Validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('id')
            ->requirePresence('id')
            ->notEmptyString('id');

        return $validator;
    }

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->id = $data['id'];

        return true;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}
