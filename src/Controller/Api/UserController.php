<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Management;

/**
 * User Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class UserController extends AppController
{
    /**
     * @return void
     */
    public function search(): void
    {
        // Management API を呼び出すサンプル

        /** @var string $domain */
        $domain = env('AUTH0_DOMAIN', '');
        /** @var string $clientId */
        $clientId = env('AUTH0_CLIENT_ID', '');
        $authApi = new Authentication($domain, $clientId);

        $config = [
            'client_id' => env('AUTH0_CLIENT_ID', ''),
            'client_secret' => env('AUTH0_CLIENT_SECRET', ''),
            'audience' => env('AUTH0_MANAGEMENT_AUDIENCE', ''),
        ];
        $credential = $authApi->client_credentials($config);

        $accessToken = $credential['access_token'];
        $mgmtApi = new Management($accessToken, $domain);

        $users = $mgmtApi->users()->getAll();

        $this->set('data', $users);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    /**
     * @param string $id id
     * @return void
     */
    public function view(string $id): void
    {
    }

    /**
     * @return void
     * @throws \App\Exception\ApplicationException
     */
    public function create(): void
    {
    }

    /**
     * @param string $id id
     * @return void
     * @throws \App\Exception\ApplicationException
     */
    public function update(string $id): void
    {
    }

    /**
     * @param string $id id
     * @return void
     * @throws \App\Exception\ApplicationException
     */
    public function delete(string $id): void
    {
    }
}
