<?php
/**
 *
 * This file is part of Atlas for PHP.
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 */
declare(strict_types=1);

namespace Cardoe\DM\Info\Adapter;

use Cardoe\DM\Pdo\Connection;

interface AdapterInterface
{
    public function __construct(Connection $connection);

    public function fetchAutoincSequence(string $table): ?string;

    public function fetchCurrentSchema(): string;

    public function fetchColumns(string $table): array;

    public function fetchTableNames(string $schema = ''): array;
}
