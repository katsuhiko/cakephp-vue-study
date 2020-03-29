<?php
declare(strict_types=1);

namespace Cas\Test\UseCase\Task;

use Cas\Domain\Model\Task;
use Cas\Domain\Model\TaskId;
use Cas\UseCase\Task\TaskSearch;
use Cas\UseCase\Task\TaskSearchQueryPort;
use PHPUnit\Framework\TestCase;

class TaskSearchTest extends TestCase
{
    /**
     * @return void
     */
    public function test_検索できること(): void
    {
        // Arrange
        $useCase = new TaskSearch(
            new class implements TaskSearchQueryPort
            {
                public function findTasks(?string $descriptionLike): array
                {
                    return [
                        new Task(
                            TaskId::of('c366f5be-360b-45cc-8282-65c80e434f72'),
                            'test1'
                        ),
                        new Task(
                            TaskId::of('bdf7096c-8eed-43be-b510-a398d405bb0a'),
                            'test2'
                        ),
                    ];
                }
            }
        );

        // Act
        $actual = $useCase->execute('test');

        // Assert
        $this->assertEquals(2, count($actual));
    }
}
