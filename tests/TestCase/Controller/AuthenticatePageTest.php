<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * AuthenticatePageTest class
 */
class AuthenticatePageTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @return void
     */
    public function test_ページアクセスで認証されている場合200がかえること(): void
    {
        // Arrange
        $this->session([
            'auth0__user' => [
                'sub' => 'auth0|xxxxxxxxxxxxxxxxxxxxxxxx',
            ],
        ]);

        // Act
        $this->get('/');

        // Assert
        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function test_ページアクセスで認証されていない場合リダイレクトされること(): void
    {
        // Act
        $this->get('/');

        // Assert
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/users/login?redirect=');
    }
}
