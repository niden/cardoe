<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Fixtures\Cache\Adapter;

use Cardoe\Cache\Adapter\Libmemcached as CacheLibmemcached;

/**
 * Cardoe\Test\Fixtures\Cache\Adapter
 *
 * Libmemcached adapter fixture
 */
class Libmemcached extends CacheLibmemcached
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
