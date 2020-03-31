<?php
declare(strict_types=1);

namespace Cas\Domain\Model;

use Cake\Utility\Text;

trait ValueObjectUuidTrait
{
    /**
     * @return self
     */
    public static function newId(): self
    {
        return new self(Text::uuid());
    }
}
