<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSessions extends AbstractMigration
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
        $this->table('sessions', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['default' => null, 'limit' => 40, 'null' => false])
            ->addColumn('data', 'blob', ['default' => null, 'limit' => null, 'null' => true])
            ->addColumn('expires', 'integer', ['default' => null, 'limit' => 11, 'null' => false])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->addColumn('modified', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => false])
            ->create();
    }
}
