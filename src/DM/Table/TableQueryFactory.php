<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Phalcon\DM\Table;

use Phalcon\DM\Query\QueryFactory;

class TableQueryFactory
{
    public function newQueryFactory(string $tableClass): QueryFactory
    {
        $selectClass = $tableClass . 'Select';
        return new QueryFactory($selectClass);
    }
}
