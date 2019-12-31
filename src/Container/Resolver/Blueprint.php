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

namespace Phalcon\Container\Resolver;

use Phalcon\Container\Exception;
use Phalcon\Container\Exception\MissingParameter;
use Phalcon\Container\Exception\MutationDoesNotImplementInterface;
use Phalcon\Container\Exception\SetterMethodNotFound;
use Phalcon\Container\Injection\LazyInterface;
use Phalcon\Container\Injection\MutationInterface;
use ReflectionClass;

use function array_merge;

/**
 * Class Blueprint
 *
 * @property string $className
 * @property array  $mutations
 * @property array  $parameters
 * @property array  $setters
 */
final class Blueprint
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $mutations;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var array
     */
    private $setters;

    /**
     * @param string $className
     * @param array  $parameters
     * @param array  $setters
     * @param array  $mutations
     */
    public function __construct(
        string $className,
        array $parameters = [],
        array $setters = [],
        array $mutations = []
    ) {
        $this->className  = $className;
        $this->parameters = $parameters;
        $this->setters    = $setters;
        $this->mutations  = $mutations;
    }

    /**
     * Instantiates a new object based on the current blueprint.
     *
     * @param ReflectionClass $reflectedClass
     *
     * @return object
     * @throws MissingParameter
     * @throws MutationDoesNotImplementInterface
     * @throws SetterMethodNotFound
     */
    public function __invoke(ReflectionClass $reflectedClass): object
    {
        $parameters = $this->parameters;
        foreach ($parameters as $index => $parameter) {
            if ($parameter instanceof UnresolvedParameter) {
                throw new MissingParameter(
                    sprintf(
                        "Parameter missing: %s::\$%s",
                        $this->className,
                        $parameter->getName()
                    )
                );
            }

            $parameters[$index] = $this->resolveLazy($parameter);
        }

        $object = $reflectedClass->newInstanceArgs($parameters);
        foreach ($this->setters as $method => $value) {
            if (!method_exists($this->className, $method)) {
                throw new SetterMethodNotFound(
                    sprintf(
                        "Setter method not found: %s::%s()",
                        $this->className,
                        $method
                    )
                );
            }

            $value = $this->resolveLazy($value);
            $object->$method($value);
        }

        /** @var MutationInterface $mutation */
        foreach ($this->mutations as $mutation) {
            $mutation = $this->resolveLazy($mutation);

            if ($mutation instanceof MutationInterface === false) {
                throw Exception::mutationDoesNotImplementInterface($mutation);
            }

            $object = $mutation($object);
        }

        return $object;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return array
     */
    public function getMutations(): array
    {
        return $this->mutations;
    }

    /**
     * @return array
     */
    public function getSetters(): array
    {
        return $this->setters;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Merges all parameters and invokes the lazy ones.
     *
     * @param Blueprint $blueprint The overrides during merging
     *
     * @return Blueprint The merged blueprint
     */
    public function merge(Blueprint $blueprint): Blueprint
    {
        return new Blueprint(
            $this->className,
            $this->mergeParameters($blueprint),
            $this->mergeSetters($blueprint),
            $this->mergeMutations($blueprint)
        );
    }

    /**
     * @param array $parameters
     *
     * @return Blueprint
     */
    public function replaceParameters(array $parameters): Blueprint
    {
        $clone             = clone $this;
        $clone->parameters = $parameters;

        return $clone;
    }

    /**
     * @param array $parameters
     *
     * @return Blueprint
     */
    public function withParams(array $parameters): Blueprint
    {
        $clone             = clone $this;
        $clone->parameters = array_merge($this->parameters, $parameters);

        return $clone;
    }

    /**
     *
     * Merges the setters with overrides; also invokes Lazy values.
     *
     * @param Blueprint $blueprint A blueprint containing additional mutations.
     *
     * @return array The merged mutations
     */
    private function mergeMutations(Blueprint $blueprint): array
    {
        return array_merge($this->mutations, $blueprint->mutations);
    }

    /**
     *
     * Merges the parameters with overrides; also invokes Lazy values.
     *
     * @param Blueprint $blueprint  A blueprint containing override parameters;
     *                              the key may be the name *or* the numeric
     *                              position of the constructor parameter,
     *                              and the value is the parameter value to use.
     *
     * @return array The merged parameters
     *
     */
    private function mergeParameters(Blueprint $blueprint): array
    {
        if (!$blueprint->parameters) {
            // no parameters to merge, micro-optimize the loop
            return $this->parameters;
        }

        $parameters = $this->parameters;

        $position = 0;
        foreach ($parameters as $key => $value) {
            // positional overrides take precedence over named overrides
            if (array_key_exists($position, $blueprint->parameters)) {
                // positional override
                $value = $blueprint->parameters[$position];
            } elseif (array_key_exists($key, $blueprint->parameters)) {
                // named override
                $value = $blueprint->parameters[$key];
            }

            // retain the merged value
            $parameters[$key] = $value;

            // next position
            $position += 1;
        }

        return $parameters;
    }

    /**
     *
     * Merges the setters with overrides; also invokes Lazy values.
     *
     * @param Blueprint $blueprint A blueprint containing override setters.
     *
     * @return array The merged setters
     */
    private function mergeSetters(Blueprint $blueprint): array
    {
        return array_merge($this->setters, $blueprint->setters);
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    private function resolveLazy($object)
    {
        if ($object instanceof LazyInterface) {
            $object = $object();
        }

        return $object;
    }
}
