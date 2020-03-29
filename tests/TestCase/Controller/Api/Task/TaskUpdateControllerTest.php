<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\Task\TaskUpdateController Test Case
 *
 * @uses \App\Controller\Api\Task\TaskUpdateController
 */
class TaskUpdateControllerTest extends TestCase
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
        $this->put("/api/ca-task/update/{$tasks[0]->id}.json", $data);

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertEquals($tasks[0]->id, $actual['data']['id']);
    }
}
