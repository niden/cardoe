<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Phalcon\DataMapper\Mapper\Relationship;

use Phalcon\DataMapper\Mapper\MapperRelationships;
use Phalcon\DataMapper\Mapper\MapperSelect;

class SubJoinWith
{
    protected $relationships;

    protected $select;

    public function __construct(
        MapperRelationships $relationships,
        MapperSelect $select,
        string $nativeAlias
    ) {
        $this->relationships = $relationships;
        $this->select        = $select;
        $this->nativeAlias   = $nativeAlias;
    }

    public function joinWith($relatedName, callable $sub = null): void
    {
        $this->relationships->joinSelect(
            $this->select,
            $this->nativeAlias,
            $relatedName,
            $sub
        );
    }
}
