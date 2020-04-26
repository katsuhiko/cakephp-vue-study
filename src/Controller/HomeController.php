<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Home Controller
 */
class HomeController extends AppController
{
    /**
     * @param \Cake\Event\EventInterface $event event
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Allow login and add
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function index(): ?Response
    {
        return $this->render();
    }
}
