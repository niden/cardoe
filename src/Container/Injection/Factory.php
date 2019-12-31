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

namespace Phalcon\Container\Injection;

use Phalcon\Container\Resolver\Blueprint;
use Phalcon\Container\Resolver\Resolver;
use ReflectionException;

/**
 * A generic factory to create repeated instances of a single class. Note that
 * it does not implement the LazyInterface, so it is not automatically invoked
 * when resolving params and setters.
 *
 * @property Blueprint         $blueprint
 * @property array|Blueprint[] $contextualBlueprints
 * @property Resolver          $resolver
 */
class Factory
{
    /**
     * Override params for the class.
     *
     * @var Blueprint
     */
    protected $blueprint;

    /**
     * Blueprints that are only used within the context of this factory.
     *
     * @var array|Blueprint[]
     */
    protected $contextualBlueprints = [];

    /**
     * The Resolver.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     *
     * Constructor.
     *
     * @param Resolver  $resolver A Resolver to provide class-creation
     *                            specifics.
     *
     * @param Blueprint $blueprint
     */
    public function __construct(
        Resolver $resolver,
        Blueprint $blueprint
    ) {
        $this->resolver  = $resolver;
        $this->blueprint = $blueprint;
    }

    /**
     * Invoke the Factory object as a function to use the Factory to create
     * a new instance of the specified class; pass sequential parameters as
     * as yet another set of constructor parameter overrides.
     *
     * Why the overrides for the overrides?  So that any package that needs a
     * factory can make its own, using sequential params in a function; then
     * the factory call can be replaced by a call to this Factory.
     *
     * @param mixed ...$params
     *
     * @return object
     * @throws ReflectionException
     */
    public function __invoke(...$params): object
    {
        return $this->resolver->resolve(
            $this->blueprint->withParams($params),
            $this->contextualBlueprints
        );
    }

    /**
     * @param Blueprint $contextualBlueprint
     *
     * @return Factory
     */
    public function withContext(Blueprint $contextualBlueprint): self
    {
        $clone                         = clone $this;
        $clone->contextualBlueprints[] = $contextualBlueprint;
        return $clone;
    }
}
