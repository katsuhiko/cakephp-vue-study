<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Form\Form;

/**
 * ErrorDetailForm
 *
 * @OA\Schema(
 *   description="エラー詳細情報",
 *   type="object",
 * )
 */
class ErrorDetailForm extends Form
{
    /**
     * @OA\Property(
     *   property="key",
     *   type="string",
     *   description="エラーキー",
     *   example="task.id.required",
     * )
     * @var string
     */
    private $key = '';

    /**
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   description="エラーメッセージ",
     *   example="必須入力項目です。",
     * )
     * @var string
     */
    private $message = '';

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->key = $data['key'];
        $this->message = $data['message'];

        return true;
    }

    /**
     * @return array{key:string, message:string}
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'message' => $this->message,
        ];
    }
}
