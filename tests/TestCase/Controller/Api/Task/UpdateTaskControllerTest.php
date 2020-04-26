<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Controller\Api\Task\UpdateTaskController Test Case
 *
 * @uses \App\Controller\Api\Task\UpdateTaskController
 */
class UpdateTaskControllerTest extends TestCase
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
        $this->assertSame($tasks[0]->id, $actual['data']['id']);

        $updated = $this->Tasks->get($actual['data']['id']);
        $this->assertSame('updated', $updated->description);
    }
}
