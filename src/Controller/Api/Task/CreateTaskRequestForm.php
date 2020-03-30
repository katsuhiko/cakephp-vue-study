<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Form\Form;
use Cake\Validation\Validator;

/**
 * CreateTaskRequestForm
 *
 * @OA\Schema(
 *   description="タスク登録リクエスト情報",
 *   type="object",
 *   required={"description"},
 * )
 */
class CreateTaskRequestForm extends Form
{
    /**
     * @OA\Property(
     *   property="description",
     *   type="string",
     *   description="タスク内容",
     *   example="朝の身だしなみチェック",
     * )
     *
     * @var string
     */
    private $description;

    /**
     * @param \Cake\Validation\Validator $validator Validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('description')
            ->requirePresence('description')
            ->notEmptyString('description');

        return $validator;
    }

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->description = $data['description'];

        return true;
    }

    /**
     * @return array{description:string}
     */
    public function data(): array
    {
        return [
            'description' => $this->description,
        ];
    }
}
