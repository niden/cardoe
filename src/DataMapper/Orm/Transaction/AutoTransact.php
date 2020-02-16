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

use Exception;
use Phalcon\DataMapper\Mapper\Mapper;
use Phalcon\DataMapper\Mapper\Record;

/**
 * Auto-begins, and then commits or rolls back, each write operation.
 */
class AutoTransact extends Transaction
{
    public function read(Mapper $mapper, string $method, array $params)
    {
        return $mapper->$method(...$params);
    }

    public function write(Mapper $mapper, string $method, Record $record): void
    {
        $this->connectionLocator->lockToWrite();
        try {
            $this->beginTransaction();
            $mapper->$method($record);
            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            $c = get_class($e);
            throw new $c($e->getMessage(), $e->getCode(), $e);
        }
    }
}