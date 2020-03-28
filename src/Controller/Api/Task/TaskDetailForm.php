<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Form\Form;
use Cake\Validation\Validator;

/**
 * TaskDetailForm
 *
 * @OA\Schema(
 *     description="タスク詳細情報",
 *     type="object",
 * )
 */
class TaskDetailForm extends Form
{
    /**
     * @OA\Property(
     *   property="id",
     *   type="string",
     *   description="タスクID",
     *   example="c366f5be-360b-45cc-8282-65c80e434f72"
     * )
     *
     * @var string
     */
    private $id = '';

    /**
     * @OA\Property(
     *   property="description",
     *   type="string",
     *   description="タスク内容",
     *   example="朝の身だしなみチェック"
     * )
     *
     * @var string
     */
    private $description = '';

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

        $validator
            ->scalar('description')
            ->requirePresence('description')
            ->allowEmptyString('description');

        return $validator;
    }

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->id = $data['id'];
        $this->description = $data['description'];

        return true;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }
}
