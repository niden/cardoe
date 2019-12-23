<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cache\Adapter;

use Phalcon\Cache\Adapter\AdapterInterface as CacheAdapterInterface;
use Phalcon\Storage\Adapter\Memory as StorageMemory;

/**
 * Memory adapter
 */
class Memory extends StorageMemory implements CacheAdapterInterface
{
}
