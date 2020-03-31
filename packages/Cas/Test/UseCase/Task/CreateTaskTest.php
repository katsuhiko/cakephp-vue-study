<?php
declare(strict_types=1);

namespace Cas\Test\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\CreateTask;
use Cas\UseCase\Task\CreateTaskCommandPort;
use Cas\UseCase\TransactionPort;
use PHPUnit\Framework\TestCase;

class CreateTaskTest extends TestCase
{
    /**
     * @return void
     */
    public function test_登録できること(): void
    {
        // Arrange
        $useCase = new CreateTask(
            new class implements CreateTaskCommandPort
            {
                public function create(Task $task): Task
                {
                    return $task;
                }
            },
            new class implements TransactionPort
            {
                public function transactional(callable $callback)
                {
                    return $callback();
                }
            }
        );
        $description = 'created';

        // Act
        $actual = $useCase->execute($description);

        // Assert
        $this->assertEquals($description, $actual->toArray()['description']);
    }
}
