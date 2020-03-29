<?php
declare(strict_types=1);

namespace Cas\Domain\Model;

trait ValueObjectStringTrait
{
    use ValueObjectOfTrait;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->asString();
    }
}
