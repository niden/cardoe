<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Phalcon\DataMapper\Mapper\Identity;

use Phalcon\DataMapper\Mapper\Exception;
use Phalcon\DataMapper\Table\Row;
use SplObjectStorage;

class IdentitySimple extends IdentityMap
{
    public function __construct(string $primaryKey)
    {
        $this->primaryKey  = $primaryKey;
        $this->rowToSerial = new SplObjectStorage();
    }

    protected function getArrayFromRow(Row $row): array
    {
        return [$row->{$this->primaryKey}];
    }

    protected function getArray($primaryVal): array
    {
        if (!is_scalar($primaryVal)) {
            throw Exception::primaryValueNotScalar($this->primaryKey, $primaryVal);
        }

        return [$primaryVal];
    }
}
