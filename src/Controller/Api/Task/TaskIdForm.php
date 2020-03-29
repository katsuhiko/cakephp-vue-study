<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Form\Form;

/**
 * TaskIdForm
 *
 * @OA\Schema(
 *   description="タスクID情報",
 *   type="object",
 * )
 */
class TaskIdForm extends Form
{
    /**
     * @OA\Property(
     *   property="id",
     *   type="string",
     *   description="タスクID",
     *   example="c366f5be-360b-45cc-8282-65c80e434f72",
     * )
     *
     * @var string
     */
    private $id;

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
     * @return array{id:string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
