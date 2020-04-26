<?php
declare(strict_types=1);

namespace App\Authenticator;

use Auth0\SDK\Auth0;
use Authentication\Authenticator\AbstractAuthenticator;
use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Session Authenticator
 */
class Auth0Authenticator extends AbstractAuthenticator
{
    /**
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @return \Auth0\SDK\Auth0
     */
    private function auth0(): Auth0
    {
        return new Auth0([
            'domain' => env('AUTH0_DOMAIN', ''),
            'client_id' => env('AUTH0_CLIENT_ID', ''),
            'client_secret' => env('AUTH0_CLIENT_SECRET', ''),
            'redirect_uri' => env('AUTH0_CALLBACK_URL', ''),

            // refresh token が必要な場合は、scope へ offline_access を追加する
            // @see https://auth0.com/docs/tokens/guides/get-refresh-tokens
            'scope' => 'openid profile email',
            // 'scope' => 'openid profile email offline_access',

            // exchange (code から access token を取得) 後、ユーザー情報を取得する場合は true とする
            // access token と一緒に返却される id token(JWT) を decode したユーザー情報でよければ false (デフォルト) とする
            // 'skip_userinfo' => false,

            // access token を Store (Session情報) へ保持しない場合は false とする
            // 'persist_user' => false,

            // access token を Store (Session情報) へ保持する場合は true とする
            'persist_access_token' => true,

            // refresh token を Store (Session情報) へ保持する場合は true とする
            // 'persist_refresh_token' => true,

            // id token を Store (Session情報) へ保持する場合は true とする
            // 'persist_id_token' => true,
        ]);
    }

    /**
     * Authenticate a user using session data.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request request
     * @return \Authentication\Authenticator\ResultInterface
     */
    public function authenticate(ServerRequestInterface $request): ResultInterface
    {
        $user = $this->auth0()->getUser();

        if (empty($user)) {
            return new Result(null, Result::FAILURE_IDENTITY_NOT_FOUND);
        }

        // $user は array なので ArrayObject へ変換しなくても OK。
        // if (!($user instanceof ArrayAccess)) {
        //     $user = new ArrayObject($user);
        // }

        return new Result($user, Result::SUCCESS);
    }
}
