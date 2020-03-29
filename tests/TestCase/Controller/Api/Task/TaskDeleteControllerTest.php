<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\Task\TaskDeleteController Test Case
 *
 * @uses \App\Controller\Api\Task\TaskDeleteController
 */
class TaskDeleteControllerTest extends TestCase
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
     * Test delete method
     *
     * @return void
     */
    public function test_削除できること(): void
    {
        // Arrange
        $tasks = Fabricate::create('Tasks');

        // Act
        $this->delete("/api/ca-task/delete/{$tasks[0]->id}.json");

        // Assert
        $this->assertResponseOk();
    }
}
