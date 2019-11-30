<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Cache\Adapter;

use Cardoe\Cache\Adapter\AdapterInterface as CacheAdapterInterface;
use Cardoe\Storage\Adapter\Redis as StorageRedis;

/**
 * Redis adapter
 */
class Redis extends StorageRedis implements CacheAdapterInterface
{
}
