<?php
declare(strict_types=1);

namespace Cas\Test\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\DeleteTask;
use Cas\UseCase\Task\DeleteTaskCommandPort;
use Cas\UseCase\TransactionPort;
use PHPUnit\Framework\TestCase;

class DeleteTaskTest extends TestCase
{
    /**
     * @return void
     */
    public function test_削除できること(): void
    {
        // Arrange
        $useCase = new DeleteTask(
            new class implements DeleteTaskCommandPort
            {
                public function delete(TaskId $id): Task
                {
                    return new Task($id, 'deleted');
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

        // Act
        $actual = $useCase->execute($id);

        // Assert
        $this->assertEquals($id->asString(), $actual->toArray()['id']);
    }
}
