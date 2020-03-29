<?php
declare(strict_types=1);

namespace App\Controller\Api\Task;

use Cake\Controller\Controller;
use Cake\Form\Form;

/**
 * TaskDeleteResponseForm
 *
 * @OA\Response(
 *   response="TaskDeleteResponseForm",
 *   description="No Content",
 * )
 */
class TaskDeleteResponseForm extends Form
{
    /**
     * @param array $data data
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        return true;
    }

    /**
     * @param \Cake\Controller\Controller $controller controller
     * @return void
     */
    public function response(Controller $controller): void
    {
        $controller->setResponse($controller->getResponse()->withStatus(204));
        $controller->viewBuilder()->setOption('serialize', []);
    }
}
