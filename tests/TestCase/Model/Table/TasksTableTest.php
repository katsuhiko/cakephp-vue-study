<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Fabricate\Fabricate;

/**
 * App\Model\Table\TasksTable Test Case
 */
class TasksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TasksTable
     */
    protected $Tasks;

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
        $config = TableRegistry::getTableLocator()->exists('Tasks') ? [] : ['className' => TasksTable::class];
        $this->Tasks = TableRegistry::getTableLocator()->get('Tasks', $config);
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
     * @return void
     */
    public function test_Fabricateを使わずにレコードを作成する(): void
    {
        // Arrange
        for ($i = 0; $i < 3; $i++) {
            $task = $this->Tasks->newEntity(['description' => 'unittest']);
            $this->Tasks->save($task);
        }

        // Act
        $tasks = $this->Tasks->find()->all();

        // Assert
        $this->assertEquals(3, count($tasks));
    }

    /**
     * @return void
     */
    public function test_Fabricateでレコードを作成する(): void
    {
        // Arrange
        Fabricate::create('Tasks', 3);

        // Act
        $tasks = $this->Tasks->find()->all();

        // Assert
        $this->assertEquals(3, count($tasks));
    }

    // 下の部分に誤りがある気がする。 PR をだす。
    // https://github.com/sizuhiko/Fabricate/blob/develop/src/Factory/FabricateDefinitionFactory.php#L45
    //
    // /**
    //  * @return void
    //  */
    // public function test_Fabricateでインスタンスを作成する(): void
    // {
    //     /** @var \App\Model\Entity\Task */
    //     $task = Fabricate::build('Tasks', function($data, $world) {
    //         return [
    //             'description' => 'test'
    //         ];
    //     });
    //     $this->Tasks->save($task);
    //     $actual = $this->Tasks->get($task->id);
    //     $this->assertEquals('test', $actual->description);
    // }
}
