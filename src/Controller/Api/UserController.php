<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Management;

/**
 * User Controller
 *
 * @see https://auth0.com/docs/api/management/v2
 */
class UserController extends AppController
{
    /**
     * @return \Auth0\SDK\API\Management
     */
    private function managementApi(): Management
    {
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

        return $mgmtApi;
    }

    /**
     * @return void
     * @see https://auth0.com/docs/api/management/v2#!/Users/get_users
     */
    public function search(): void
    {
        $mgmtApi = $this->managementApi();

        $users = $mgmtApi->users()->getAll();

        $this->set('data', $users);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    /**
     * @param string $id id
     * @return void
     * @see https://auth0.com/docs/api/management/v2#!/Users/get_users_by_id
     */
    public function view(string $id): void
    {
        $mgmtApi = $this->managementApi();

        $users = $mgmtApi->users()->get($id);

        $this->set('data', $users);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    /**
     * @return void
     * @see https://auth0.com/docs/api/management/v2#!/Users/post_users
     */
    public function create(): void
    {
        $mgmtApi = $this->managementApi();

        $data = $this->request->getData();
        $userData = [
            'email' => $data['email'],
            'password' => $data['password'],
            'connection' => 'Username-Password-Authentication',
            'email_verified' => true,
        ];
        $user = $mgmtApi->users()->create($userData);

        $this->set('data', $user);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    /**
     * @param string $id id
     * @return void
     * @see https://auth0.com/docs/api/management/v2#!/Users/patch_users_by_id
     */
    public function update(string $id): void
    {
        $mgmtApi = $this->managementApi();

        $data = $this->request->getData();
        // 同時に更新できない項目があるので API ドキュメントを参照すること
        $userData = [
            'name' => $data['name'],
            'nickname' => $data['nickname'],
        ];
        $user = $mgmtApi->users()->update($id, $userData);

        $this->set('data', $user);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }

    /**
     * @param string $id id
     * @return void
     * @see https://auth0.com/docs/api/management/v2#!/Users/delete_users_by_id
     */
    public function delete(string $id): void
    {
        $mgmtApi = $this->managementApi();

        $user = $mgmtApi->users()->delete($id);

        $this->set('data', $user);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
