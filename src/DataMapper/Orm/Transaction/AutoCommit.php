<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Phalcon\DataMapper\Orm\Transaction;

use Phalcon\DataMapper\Mapper\Mapper;
use Phalcon\DataMapper\Mapper\Record;

/**
 * Support for manual transaction control.
 */
class AutoCommit extends Transaction
{
    public function read(Mapper $mapper, string $method, array $params)
    {
        return $mapper->$method(...$params);
    }

    public function write(Mapper $mapper, string $method, Record $record): void
    {
        $this->connectionLocator->lockToWrite();
        $mapper->$method($record);
    }
}
