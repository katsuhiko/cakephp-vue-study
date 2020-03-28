<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Collection\Collection;
use Cake\Controller\Controller;
use Cake\Form\Form;
use Cake\Utility\Hash;

/**
 * ValidationErrorResponseForm
 *
 * @OA\Response(
 *   response="ValidationErrorResponseForm",
 *   description="バリデーションエラー",
 *   @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponseForm"),
 * )
 *
 * @OA\Schema(
 *   description="バリデーションエラーレスポンス情報",
 *   type="object",
 * )
 */
class ValidationErrorResponseForm extends Form
{
    /**
     * @OA\Property(
     *   property="errors",
     *   type="array",
     *   description="エラー一覧情報",
     *   @OA\Items(ref="#/components/schemas/ErrorDetailForm"),
     * )
     *
     * @var \App\Controller\Api\ErrorDetailForm[]
     */
    private $errors = [];

    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $errors = Hash::flatten($data);
        $this->errors = (new Collection($errors))->map(function ($error) {
            $errorDetail = new ErrorDetailForm();
            $errorDetail->execute($error);

            return $errorDetail;
        })->toArray();

        return true;
    }

    /**
     * @param \Cake\Controller\Controller $controller controller
     * @return void
     */
    public function response(Controller $controller): void
    {
        $errors = (new Collection($this->errors))->map(function ($errorDetail) {
            return $errorDetail->toArray();
        })->toArray();

        $controller->setResponse($controller->getResponse()->withStatus(403));
        $controller->set('errors', $errors);
        $controller->viewBuilder()->setOption('serialize', ['errors']);
    }

    /**
     * @param \Cake\Controller\Controller $controller controller
     * @param array $errors errors
     * @return void
     */
    public static function error(Controller $controller, $errors): void
    {
        $errorForm = new ValidationErrorResponseForm();
        $errorForm->execute($errors);
        $errorForm->response($controller);
    }
}
