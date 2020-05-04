<?php
declare(strict_types=1);

namespace App\Authenticator;

use Authentication\Authenticator\AbstractAuthenticator;
use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Swagger Authenticator
 */
class SwaggerAuthenticator extends AbstractAuthenticator
{
    /**
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Authenticate a user using session data.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request request
     * @return \Authentication\Authenticator\ResultInterface
     */
    public function authenticate(ServerRequestInterface $request): ResultInterface
    {
        // ローカル開発モードのときのみ Swagger によるアクセスを許可するため
        // ローカル開発モードのとき以外は、ユーザー情報なしで返却する
        if (filter_var(env('SERVER', false))) {
            return new Result(null, Result::FAILURE_OTHER, ['Not support Swagger.']);
        }

        $user = $request->getHeaderLine('x-api-user-local');
        if (!$user) {
            return new Result(null, Result::FAILURE_CREDENTIALS_MISSING);
        }

        return new Result(json_decode($user, true), Result::SUCCESS);
    }
}
