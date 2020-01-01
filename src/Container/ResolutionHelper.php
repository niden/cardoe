<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AuraPHP
 *
 * @link    https://github.com/auraphp/Aura.Di
 * @license https://github.com/auraphp/Aura.Di/blob/4.x/LICENSE
 */

declare(strict_types=1);

namespace Phalcon\Container;

use Phalcon\Container;
use ReflectionException;

/**
 * Resolves object specifications using the DI container.
 *
 * @property Container $container
 */
class ResolutionHelper
{
    /**
     * The DI container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param Container $container The DI container.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Resolves an object specification.
     *
     * @param mixed $spec The object specification.
     *
     * @return array|object
     * @throws ReflectionException
     */
    public function __invoke($spec)
    {
        if (is_string($spec)) {
            return $this->resolve($spec);
        }

        if (is_array($spec) && is_string($spec[0])) {
            $spec[0] = $this->resolve($spec[0]);
        }

        return $spec;
    }

    /**
     * Get a named service or a new instance from the Container
     *
     * @param string $spec the name of the service or class to instantiate
     *
     * @return object
     * @throws Exception\ServiceNotFound
     * @throws ReflectionException
     */
    protected function resolve($spec)
    {
        if ($this->container->has($spec)) {
            return $this->container->get($spec);
        }

        return $this->container->newInstance($spec);
    }
}

