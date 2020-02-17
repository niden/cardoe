<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cache;

use Phalcon\Cache;
use Phalcon\Factory\Exception as FactoryException;

/**
 * Creates a new Cache class
 *
 * @property AdapterFactory $adapterFactory
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
     * @throws FactoryException
     */
    public function newInstance(string $name, array $options = []): Cache
    {
        $adapter = $this->adapterFactory->newInstance($name, $options);

        return new Cache($adapter);
    }
}
