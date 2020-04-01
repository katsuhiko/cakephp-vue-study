<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Controller\Api\Task\CreateTaskAdapter;
use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use PDOException;

/**
 * App\Controller\Api\Task\CreateTaskAdapter Test Case
 */
class CreateTaskAdapterTest extends TestCase
{
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
     * @var \App\Controller\Api\Task\CreateTaskAdapter
     */
    protected $adapter;

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
        $this->adapter = new CreateTaskAdapter();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->adapter);
        unset($this->Tasks);
        parent::tearDown();
    }

    /**
     * @return void
     */
    public function test_指定したUUIDで登録できること(): void
    {
        // Arrange
        $taskId = TaskId::of('aa08b42c-815b-49f4-b3ec-1b14713ceb69');

        // Act
        $this->adapter->create(new Task($taskId, 'created'));

        // Assert
        $this->assertNotNull($this->Tasks->get($taskId->asString()));
    }

    /**
     * @return void
     */
    public function test_同じUUIDの情報を登録できないこと(): void
    {
        // Arrange
        $taskId = TaskId::of('aa08b42c-815b-49f4-b3ec-1b14713ceb69');
        $this->adapter->create(new Task($taskId, 'created'));

        // Expect
        $this->expectException(PDOException::class);

        // Act
        $this->adapter->create(new Task($taskId, 'double'));
    }
}
