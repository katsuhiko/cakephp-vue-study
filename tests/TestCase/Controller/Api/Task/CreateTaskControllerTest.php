<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Api\Task\CreateTaskController Test Case
 *
 * @uses \App\Controller\Api\Task\CreateTaskController
 */
class CreateTaskControllerTest extends TestCase
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
     * Test create method
     *
     * @return void
     */
    public function test_登録できること(): void
    {
        // Arrange
        $data = ['description' => 'created'];

        // Act
        $this->post('/api/ca-task/create.json', $data);

        // Assert
        $this->assertResponseOk();
        $actual = json_decode(strval($this->_response->getBody()), true);
        $this->assertNotNull($actual['data']['id']);
    }
}
