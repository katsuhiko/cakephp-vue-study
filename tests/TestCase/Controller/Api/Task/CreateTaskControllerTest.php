<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Task;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
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

        $created = $this->Tasks->get($actual['data']['id']);
        $this->assertSame('created', $created->description);
    }
}
