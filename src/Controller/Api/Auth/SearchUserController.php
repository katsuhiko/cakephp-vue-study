<?php
declare(strict_types=1);

namespace App\Controller\Api\Auth;

use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Management;
use App\Controller\AppController;

/**
 * SearchUserController
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class SearchUserController extends AppController
{
    /**
     * @return void
     */
    public function execute(): void
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
}
