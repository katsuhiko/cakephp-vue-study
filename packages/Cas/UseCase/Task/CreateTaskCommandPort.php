<?php
declare(strict_types=1);

namespace Cas\UseCase\Task;

use Cas\Domain\Model\Task;

interface CreateTaskCommandPort
{
    /**
     * @param string $description description
     * @return \Cas\Domain\Model\Task|null
     */
    public function create(string $description): ?Task;
}
