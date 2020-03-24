<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * CORS Controller
 */
class CorsController extends AppController
{
    /**
     * @return void
     */
    public function option(): void
    {
        $this->viewBuilder()->setOption('serialize', []);
    }
}
