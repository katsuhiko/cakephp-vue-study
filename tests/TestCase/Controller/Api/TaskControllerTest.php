<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\TaskController Test Case
 *
 * @uses \App\Controller\Api\TaskController
 */
class TaskControllerTest extends TestCase
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
     * Test search method
     *
     * @return void
     */
    public function test_全件取得できること(): void
    {
        // Arrange
        Fabricate::create('Tasks', 3);

        // Act
        $this->get('/api/task/search.json');

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertEquals(3, count($actual['tasks']));
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function test_タスク内容で絞って取得できること(): void
    {
        // Arrange
        Fabricate::create('Tasks', 2, ['description' => '検索キーワードあり']);
        Fabricate::create('Tasks', 1, ['description' => '何もなし']);

        // Act
        $this->get('/api/task/search.json?description_like=キーワード');

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertEquals(2, count($actual['tasks']));
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function test_該当1件を取得できること(): void
    {
        // Arrange
        $tasks = Fabricate::create('Tasks');

        // Act
        $this->get("/api/task/view/{$tasks[0]->id}.json");

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertEquals($tasks[0]->id, $actual['task']['id']);
    }

    /**
     * Test create method
     *
     * @return void
     */
    public function test_登録できること(): void
    {
        // Arrange
        $data = ['description' => 'created'];

        // Act
        $this->post('/api/task/create.json', $data);

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertNotNull($actual['task']['id']);
    }

    /**
     * Test update method
     *
     * @return void
     */
    public function test_更新できること(): void
    {
        // Arrange
        $tasks = Fabricate::create('Tasks', ['description' => 'created']);
        $data = ['description' => 'updated'];

        // Act
        $this->put("/api/task/update/{$tasks[0]->id}.json", $data);

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertEquals($tasks[0]->id, $actual['task']['id']);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function test_削除できること(): void
    {
        // Arrange
        $tasks = Fabricate::create('Tasks');

        // Act
        $this->delete("/api/task/delete/{$tasks[0]->id}.json");

        // Assert
        $this->assertResponseOk();
    }
}
