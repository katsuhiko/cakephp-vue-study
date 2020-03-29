<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

interface TaskSearchQueryPort
{
    /**
     * @param string|null $descriptionLike descriptionLike
     * @return \Cas\Domain\Model\Task[]
     */
    public function findTasks(?string $descriptionLike): array;
}
