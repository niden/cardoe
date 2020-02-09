<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Phalcon\DataMapper\Mapper;

use Phalcon\DataMapper\Query\QueryFactory;
use Phalcon\DataMapper\Table\TableQueryFactory;

class MapperQueryFactory extends TableQueryFactory
{
    public function newQueryFactory(string $tableClass): QueryFactory
    {
        $selectClass = substr($tableClass, 0, -5) . 'Select';
        return new QueryFactory($selectClass);
    }
}
