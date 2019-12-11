<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Cardoe\DM\Mapper\Relationship;

use Cardoe\DM\Mapper\Record;

abstract class DeletableRelationship extends RegularRelationship
{
    public const CASCADE      = 'CASCADE';
    public const INIT_DELETED = 'INIT_DELETED';
    public const SET_DELETE   = 'SET_DELETE';
    public const SET_NULL     = 'SET_NULL';

    protected $onDelete;

    public function onDeleteCascade(): Relationship
    {
        $this->onDelete = static::CASCADE;
        return $this;
    }

    public function onDeleteInitDeleted(): Relationship
    {
        $this->onDelete = static::INIT_DELETED;
        return $this;
    }

    public function onDeleteSetDelete(): Relationship
    {
        $this->onDelete = static::SET_DELETE;
        return $this;
    }

    public function onDeleteSetNull(): Relationship
    {
        $this->onDelete = static::SET_NULL;
        return $this;
    }

    protected function fixForeignRecordDeleted(
        Record $nativeRecord,
        Record $foreignRecord
    ): void {
        $nativeRow = $nativeRecord->getRow();
        if ($nativeRow->getStatus() !== $nativeRow::DELETED) {
            return;
        }

        if ($this->onDelete === static::INIT_DELETED) {
            $foreignRow = $foreignRecord->getRow();
            $foreignRow->init($foreignRow::DELETED);
            return;
        }

        if ($this->onDelete === static::CASCADE) {
            $this->getForeignMapper()->delete($foreignRecord);
            return;
        }

        if ($this->onDelete === static::SET_DELETE) {
            $foreignRecord->setDelete();
            return;
        }

        if ($this->onDelete === static::SET_NULL) {
            foreach ($this->on as $nativeField => $foreignField) {
                $foreignRecord->$foreignField = null;
            }
            return;
        }
    }
}
