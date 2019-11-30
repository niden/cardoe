<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

namespace Cardoe\Test\Fixtures\Storage\Adapter;

use Cardoe\Storage\Adapter\Libmemcached as StorageLibmemcached;

/**
 * Cardoe\Test\Fixtures\Storage\Adapter
 *
 * Libmemcached adapter fixture
 */
class Libmemcached extends StorageLibmemcached
{
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param \DateInterval|int|null $ttl
     *
     * @return DateIntervalint|null
     * @throws \Exception
     */
    public function getTtl($ttl = null): int
    {
        return parent::getTtl($ttl);
    }
}
