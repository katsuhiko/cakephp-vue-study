<?php
declare(strict_types=1);

namespace Cas\Domain\Model;

class TaskId
{
    use ValueObjectStringTrait;
    use ValueObjectUuidTrait;

    /**
     * @param string $value value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }
}
