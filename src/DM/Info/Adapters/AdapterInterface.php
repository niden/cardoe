<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\DM\Info\Adapter;

use Cardoe\DM\Pdo\Connection\ConnectionInterface;

interface AdapterInterface
{
    public function __construct(ConnectionInterface $connection);

    public function fetchAutoincSequence(string $table): ?string;

    public function fetchCurrentSchema(): string;

    public function fetchColumns(string $table): array;

    public function fetchTableNames(string $schema = ""): array;
}
