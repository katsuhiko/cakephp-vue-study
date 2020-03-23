<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\Chronos\Chronos;
use Cake\Datasource\ConnectionInterface;
use Cake\TestSuite\Fixture\TestFixture;
use Fabricate\Fabricate;

/**
 * TasksFixture
 */
class TasksFixture extends TestFixture
{
    /**
     * @var array
     */
    public $import = ['model' => 'Tasks'];

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        parent::init();
    }

    public function create(ConnectionInterface $db): bool
    {
        $result = parent::create($db);

        Fabricate::define('Tasks', function ($data, $world) {
            $now = Chronos::now();

            return [
                'id' => $world->faker()->uuid,
                'description' => $world->faker()->text,
                'created' => $now->toIso8601String(),
                'modified' => $now->toIso8601String(),
            ];
        });

        return $result;
    }
}
