<?php
declare(strict_types=1);

namespace Cas\Domain\Model;

trait ValueObjectOfTrait
{
    /**
     * @param mixed $value value
     * @return self
     */
    public static function of($value): self
    {
        if ($value instanceof static) {
            return $value;
        }

        return new self($value);
    }
}
