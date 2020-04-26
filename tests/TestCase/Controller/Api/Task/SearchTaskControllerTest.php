<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\Task\SearchTaskController Test Case
 *
 * @uses \App\Controller\Api\Task\SearchTaskController
 */
class SearchTaskControllerTest extends TestCase
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
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        // 認証を通す。
        $this->session([
            'auth0__user' => [
                'sub' => 'auth0|xxxxxxxxxxxxxxxxxxxxxxxx',
            ],
        ]);
    }

    /**
     * @return void
     */
    public function test_検索できること(): void
    {
        // Arrange
        Fabricate::create('Tasks', 3);

        // Act
        $this->get('/api/ca-task/search.json');

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertSame(3, count($actual['data']));
    }

    /**
     * @return void
     */
    public function test_タスク内容で絞って検索できること(): void
    {
        // Arrange
        Fabricate::create('Tasks', 2, ['description' => '検索キーワードあり']);
        Fabricate::create('Tasks', 1, ['description' => '何もなし']);

        // Act
        $this->get('/api/ca-task/search.json?description_like=キーワード');

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertSame(2, count($actual['data']));
    }

    /**
     * @return void
     */
    public function test_タスク内容が空の場合入力チェックエラーとなること(): void
    {
        // Arrange
        Fabricate::create('Tasks', 3);

        // Act
        $this->get('/api/ca-task/search.json?description_like=');

        // Assert
        $this->assertResponseCode(403);
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertSame(1, count($actual['errors']));
    }
}
