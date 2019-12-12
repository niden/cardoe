<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\DM\Pdo;

use Cardoe\DM\Pdo\Connection;
use Cardoe\DM\Pdo\Profiler\ProfilerInterface;

class ConnectionFixture extends Connection
{
    public function __construct(
        string $dsn,
        string $username = null,
        string $password = null,
        array $options = [],
        array $queries = [],
        ProfilerInterface $profiler = null
    ) {
        $this->pdo = new PdoFixture();
    }
}
