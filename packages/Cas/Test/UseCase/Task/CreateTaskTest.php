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
                public function create(string $description): Task
                {
                    return new Task(TaskId::of('c366f5be-360b-45cc-8282-65c80e434f72'), $description);
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
