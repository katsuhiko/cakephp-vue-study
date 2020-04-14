<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CopyTasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CopyTasksTable Test Case
 */
class CopyTasksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CopyTasksTable
     */
    protected $CopyTasks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CopyTasks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CopyTasks') ? [] : ['className' => CopyTasksTable::class];
        $this->CopyTasks = TableRegistry::getTableLocator()->get('CopyTasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CopyTasks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
