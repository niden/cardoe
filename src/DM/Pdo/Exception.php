<?php

/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license https://opensource.org/licenses/MIT MIT
 *
 */

declare(strict_types=1);

namespace Cardoe\DM\Pdo;

use Throwable;

class Exception extends \Exception implements Throwable
{
    public static function connectionNotFound(
        string $type,
        string $name
    ): Exception {
        return new Exception("Connection not found: {$type}:{$name}");
    }
}
