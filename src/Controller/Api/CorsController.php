<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * CORS Controller
 */
class CorsController extends AppController
{
    /**
     * @return void
     */
    public function options(): void
    {
        // ローカル開発モードのときのみ CORS に対応する
        if (filter_var(env('SERVER', false))) {
            throw new NotFoundException('Not support CORS.');
        }

        $this->viewBuilder()->setOption('serialize', []);
    }
}
