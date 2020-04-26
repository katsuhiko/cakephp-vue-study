<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\Task\DeleteTaskController Test Case
 *
 * @uses \App\Controller\Api\Task\DeleteTaskController
 */
class DeleteTaskControllerTest extends TestCase
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
     * @var \App\Model\Table\TasksTable
     */
    protected $Tasks;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tasks') ? [] : ['className' => TasksTable::class];
        $this->Tasks = TableRegistry::getTableLocator()->get('Tasks', $config);

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
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Tasks);
        parent::tearDown();
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

        $deleted = $this->Tasks->findById($tasks[0]->id)->first();
        $this->assertNull($deleted);
    }
}
