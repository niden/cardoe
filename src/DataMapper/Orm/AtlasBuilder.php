<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Phalcon\DataMapper\Orm;

use Phalcon\DataMapper\Mapper\MapperLocator;
use Phalcon\DataMapper\Mapper\MapperQueryFactory;
use Phalcon\DataMapper\Orm\Transaction\AutoCommit;
use Phalcon\DataMapper\Pdo\ConnectionLocator;
use Phalcon\DataMapper\Table\TableLocator;

class AtlasBuilder
{
    protected $connectionLocator;

    protected $factory;

    protected $transactionClass = AutoCommit::CLASS;

    public function __construct(...$args)
    {
        $this->connectionLocator = ConnectionLocator::new(...$args);
    }

    public function getConnectionLocator(): ConnectionLocator
    {
        return $this->connectionLocator;
    }

    public function setFactory(callable $factory): void
    {
        $this->factory = $factory;
    }

    public function setTransactionClass(string $transactionClass): void
    {
        $this->transactionClass = $transactionClass;
    }

    public function newAtlas()
    {
        $tableLocator = new TableLocator(
            $this->connectionLocator,
            new MapperQueryFactory(),
            $this->factory
        );

        $transactionClass = $this->transactionClass;
        return new Atlas(
            new MapperLocator($tableLocator, $this->factory),
            new $transactionClass($this->getConnectionLocator())
        );
    }
}
