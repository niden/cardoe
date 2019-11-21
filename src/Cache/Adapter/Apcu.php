<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Cache\Adapter;

use Cardoe\Cache\Adapter\AdapterInterface as CacheAdapterInterface;
use Cardoe\Storage\Adapter\Apcu as StorageApcu;

/**
 * Apcu adapter
 */
class Apcu extends StorageApcu implements CacheAdapterInterface
{
}