<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * AuthenticateApiTest class
 */
class AuthenticateApiTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Tasks',
    ];

    /**
     * @return void
     */
    public function test_APIアクセスで認証されている場合200がかえること(): void
    {
        // Arrange
        $this->session([
            'auth0__user' => [
                'sub' => 'auth0|xxxxxxxxxxxxxxxxxxxxxxxx',
            ],
        ]);

        // Act
        $this->get('/api/ca-task/search.json');

        // Assert
        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function test_APIアクセスで認証されていない場合401がかえること(): void
    {
        // Act
        $this->get('/api/ca-task/search.json');

        // Assert
        $this->assertResponseCode(401);
    }
}
