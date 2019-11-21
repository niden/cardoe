<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Cache;

use Cardoe\Config;
use Cardoe\Factory\Exception as ExceptionAlias;

/**
 * Creates a new Cache class
 */
class CacheFactory
{
    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    /**
     * CacheFactory constructor.
     *
     * @param AdapterFactory $factory
     */
    public function __construct(AdapterFactory $factory)
    {
        $this->adapterFactory = $factory;
    }

    /**
     * Constructs a new Cache instance.
     *
     * @param string $name
     * @param array  $options
     *
     * @return Cache
     * @throws ExceptionAlias
     */
    public function newInstance(string $name, array $options = []): Cache
    {
        $adapter = $this->adapterFactory->newInstance($name, $options);

        return new Cache($adapter);
    }
}
