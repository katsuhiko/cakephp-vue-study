<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateTasks extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('tasks', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', ['default' => null, 'null' => false])
            ->addColumn('description', 'text', ['default' => null, 'limit' => null, 'null' => false])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();
    }
}
