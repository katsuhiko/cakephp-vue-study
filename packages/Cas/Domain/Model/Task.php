<?php
declare(strict_types=1);

namespace Cas\Domain\Model;

class Task
{
    /**
     * @var \Cas\Domain\Model\TaskId
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @param \Cas\Domain\Model\TaskId $id id
     * @param string $description description
     */
    public function __construct(TaskId $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    /**
     * @return array{id:string, description:string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->asString(),
            'description' => $this->description,
        ];
    }
}
