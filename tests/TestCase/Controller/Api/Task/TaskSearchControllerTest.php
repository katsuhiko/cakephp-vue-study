<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\Task\TaskSearchController Test Case
 *
 * @uses \App\Controller\Api\Task\TaskSearchController
 */
class TaskSearchControllerTest extends TestCase
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
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
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
        $this->assertEquals(3, count($actual['data']));
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
        $this->assertEquals(2, count($actual['data']));
    }
}
