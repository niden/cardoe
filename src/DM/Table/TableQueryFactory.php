<?php
/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */
declare(strict_types=1);

namespace Cardoe\DM\Table;

use Cardoe\DM\Query\QueryFactory;

class TableQueryFactory
{
    public function newQueryFactory(string $tableClass): QueryFactory
    {
        $selectClass = $tableClass . 'Select';
        return new QueryFactory($selectClass);
    }
}
