<?php
declare(strict_types=1);

namespace Cas\Test\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\ViewTask;
use Cas\UseCase\Task\ViewTaskQueryPort;
use PHPUnit\Framework\TestCase;

class ViewTaskTest extends TestCase
{
    /**
     * @return void
     */
    public function test_検索できること(): void
    {
        // Arrange
        $useCase = new ViewTask(
            new class implements ViewTaskQueryPort
            {
                public function findTask(TaskId $id): ?Task
                {
                    return new Task($id, 'viewed');
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
