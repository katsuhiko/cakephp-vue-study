<?php
declare(strict_types=1);

namespace App\Controller;

use Auth0\SDK\API\Authentication;
use Auth0\SDK\Auth0;
use Cake\Http\Response;

/**
 * Auth Controller
 */
class AuthController extends AppController
{
    /**
     * @return \Cake\Http\Response|null
     */
    public function login(): ?Response
    {
        $auth0 = new Auth0([
            'domain' => env('AUTH0_DOMAIN', ''),
            'client_id' => env('AUTH0_CLIENT_ID', ''),
            'client_secret' => env('AUTH0_CLIENT_SECRET', ''),
            'redirect_uri' => env('AUTH0_CALLBACK_URL', ''),
            'scope' => 'openid profile email',
        ]);

        $loginUrl = $auth0->getLoginUrl();

        return $this->redirect($loginUrl);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout(): ?Response
    {
        $auth0 = new Auth0([
            'domain' => env('AUTH0_DOMAIN', ''),
            'client_id' => env('AUTH0_CLIENT_ID', ''),
            'client_secret' => env('AUTH0_CLIENT_SECRET', ''),
            'redirect_uri' => env('AUTH0_CALLBACK_URL', ''),
            'scope' => 'openid profile email',
        ]);

        $auth0->logout();

        /** @var string $domain */
        $domain = env('AUTH0_DOMAIN', '');
        /** @var string $clientId */
        $clientId = env('AUTH0_CLIENT_ID', '');
        /** @var string $returnTo */
        $returnTo = env('AUTH0_LOGOUT_URL', '');

        $authApi = new Authentication($domain, $clientId);
        $logoutUrl = $authApi->get_logout_link($returnTo, $clientId);

        return $this->redirect($logoutUrl);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function callback(): ?Response
    {
        $auth0 = new Auth0([
            'domain' => env('AUTH0_DOMAIN', ''),
            'client_id' => env('AUTH0_CLIENT_ID', ''),
            'client_secret' => env('AUTH0_CLIENT_SECRET', ''),
            'redirect_uri' => env('AUTH0_CALLBACK_URL', ''),
            'scope' => 'openid profile email',
        ]);

        $userInfo = $auth0->getUser();
        //debug($userInfo);

        return $this->render();
    }
}
