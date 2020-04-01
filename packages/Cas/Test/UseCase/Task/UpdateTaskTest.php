<?php
declare(strict_types=1);

namespace Cas\Test\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\UpdateTask;
use Cas\UseCase\Task\UpdateTaskCommandPort;
use Cas\UseCase\TransactionPort;
use PHPUnit\Framework\TestCase;

class UpdateTaskTest extends TestCase
{
    /**
     * @return void
     */
    public function test_更新できること(): void
    {
        // Arrange
        $useCase = new UpdateTask(
            new class implements UpdateTaskCommandPort
            {
                public function update(Task $task): Task
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
        $id = TaskId::of('c366f5be-360b-45cc-8282-65c80e434f72');
        $description = 'updated';

        // Act
        $actual = $useCase->execute($id, $description);

        // Assert
        $this->assertEquals($id->asString(), $actual->toArray()['id']);
        $this->assertEquals($description, $actual->toArray()['description']);
    }
}
