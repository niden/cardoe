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
use Phalcon\Container\Exception\NoSuchProperty;
use ReflectionException;
use ReflectionParameter;

use function array_merge;

/**
 * Resolves class creation specifics based on constructor params and setter
 * definitions, unified across class defaults, inheritance hierarchies, and
 * configuration.
 *
 * @property ValueObject    $mutations
 * @property ValueObject    $parameters
 * @property Reflector      $reflector
 * @property ValueObject    $setters
 * @property ValueObject    $values
 * @property ValueObject    $unified
 */
class Resolver
{
    /**
     * Setter definitions in the form of `$mutations[$class][] = $value`.
     *
     * @var ValueObject
     */
    private $mutations;

    /**
     * Constructor params in the form `$params[$class][$name] = $value`.
     *
     * @var ValueObject
     */
    private $parameters;

    /**
     * A Reflector.
     *
     * @var Reflector
     */
    private $reflector;

    /**
     * Setter definitions in the form of `$setters[$class][$method] = $value`.
     *
     * @var ValueObject
     */
    private $setters;

    /**
     * Constructor params and setter definitions, unified across class
     * defaults, inheritance hierarchies, and configuration.
     *
     * @var ValueObject
     */
    private $unified;

    /**
     * Arbitrary values in the form of `$values[$key] = $value`.
     *
     * @var ValueObject
     */
    private $values;

    /**
     *
     * Constructor.
     *
     * @param Reflector $reflector A collection point for Reflection data.
     *
     */
    public function __construct(Reflector $reflector)
    {
        $this->reflector  = $reflector;
        $this->mutations  = new ValueObject();
        $this->parameters = new ValueObject();
        $this->setters    = new ValueObject();
        $this->unified    = new ValueObject();
        $this->values     = new ValueObject();
    }

    /**
     * Returns the unified constructor params and setters for a class.
     *
     * @param string $class The class name to return values for.
     *
     * @return Blueprint A blueprint how to construct an object
     * @throws ReflectionException
     */
    public function getUnified(string $class): Blueprint
    {
        // have values already been unified for this class?
        if ($this->unified->has($class)) {
            return $this->unified->get($class);
        }

        // fetch the values for parents so we can inherit them
        $parent = get_parent_class($class);
        if ($parent) {
            $spec = $this->getUnified($parent);
        } else {
            $spec = new Blueprint($class);
        }

        // stores the unified params and setters
        $this->unified->set(
            $class,
            new Blueprint(
                $class,
                $this->getUnifiedParameters($class, $spec->getParameters()),
                $this->getUnifiedSetters($class, $spec->getSetters()),
                $this->getUnifiedMutations($class, $spec->getMutations())
            )
        );

        // done, return the unified values
        return $this->unified->get($class);
    }

    public function mutations(): ValueObject
    {
        return $this->mutations;
    }

    public function parameters(): ValueObject
    {
        return $this->parameters;
    }

    /**
     * Creates and returns a new instance of a class using reflection and
     * the configuration parameters, optionally with overrides, invoking Lazy
     * values along the way.
     *
     * @param Blueprint $blueprint The blueprint to be resolved containing
     *                             its overrides for this specific case.
     * @param array     $contextualBlueprints
     *
     * @return object
     * @throws NoSuchProperty
     * @throws ReflectionException
     */
    public function resolve(Blueprint $blueprint, array $contextualBlueprints = []): object
    {
        if ($contextualBlueprints === []) {
            return call_user_func(
                $this->expandParameters(
                    $this
                        ->getUnified($blueprint->getClassName())
                        ->merge($blueprint)
                ),
                $this->reflector->getClass($blueprint->getClassName())
            );
        }

        $remember = new self($this->reflector);

        foreach ($contextualBlueprints as $contextualBlueprint) {
            $className = $contextualBlueprint->getClassName();

            $remember->parameters->set($className, $this->parameters->get($className, []));
            $remember->setters->set($className, $this->setters->get($className, []));
            $remember->mutations->set($className, $this->mutations->get($className, []));

            $this->parameters->merge($className, $contextualBlueprint->getParams());
            $this->setters->merge($className, $contextualBlueprint->getSetters());
            $this->mutations->merge($className, $contextualBlueprint->getMutations());

            $this->unified->remove($className);
        }

        $resolved = call_user_func(
            $this->expandParameters($this->getUnified($blueprint->getClassName())->merge($blueprint)),
            $this->reflector->getClass($blueprint->getClassName())
        );

        foreach ($contextualBlueprints as $contextualBlueprint) {
            $className = $contextualBlueprint->getClassName();

            $this->parameters->set($className, $remember->parameters->get($className, []));
            $this->setters->set($className, $remember->setters->get($className, []));
            $this->mutations->set($className, $remember->mutations->get($className, []));

            if ($remember->unified->has($className)) {
                $this->unified->set($className, $remember->unified->get($className));
            } else {
                $this->unified->remove($className);
            }
        }

        return $resolved;
    }

    public function setters(): ValueObject
    {
        return $this->setters;
    }

    public function unified(): ValueObject
    {
        return $this->unified;
    }

    public function values(): ValueObject
    {
        return $this->values;
    }

    /**
     * Returns the unified mutations for a class.
     *
     * Class-specific mutations are executed last before trait-based mutations
     * and before interface-based mutations.
     *
     * @param string $class  The class name to return values for.
     * @param array  $parent The parent unified setters.
     *
     * @return array The unified mutations.
     */
    protected function getUnifiedMutations(string $class, array $parent): array
    {
        $unified = $parent;

        // look for interface mutations
        $interfaces = class_implements($class);
        foreach ($interfaces as $interface) {
            if ($this->mutations->has($interface)) {
                $unified = $this->mutations->merge($interface, $unified);
            }
        }

        // look for trait mutations
        $traits = $this->reflector->getTraits($class);
        foreach ($traits as $trait) {
            if ($this->mutations->has($trait)) {
                $unified = $this->mutations->merge($trait, $unified);
            }
        }

        // look for class mutations
        if ($this->mutations->has($class)) {
            $unified = array_merge(
                $unified,
                $this->mutations->get($class)
            );
        }

        return $unified;
    }

    /**
     * Returns a unified param.
     *
     * @param ReflectionParameter $rparam A parameter reflection.
     * @param string              $class  The class name to return values for.
     * @param array               $parent The parent unified params.
     *
     * @return mixed|DefaultValueParameter|UnresolvedParameter
     * @throws ReflectionException
     */
    protected function getUnifiedParameter(ReflectionParameter $rparam, string $class, array $parent)
    {
        $name     = $rparam->getName();
        $position = $rparam->getPosition();

        // is there a positional value explicitly from the current class?
        $explicitPosition = $this->parameters->has($class)
            && array_key_exists($position, $this->parameters->get($class))
            && !$this->parameters->get($class)[$position] instanceof UnresolvedParameter;

        if ($explicitPosition) {
            return $this->parameters->get($class)[$position];
        }

        // is there a named value explicitly from the current class?
        $explicitNamed = $this->parameters->has($class)
            && array_key_exists($name, $this->parameters->get($class))
            && !$this->parameters->get($class)[$name] instanceof UnresolvedParameter;

        if ($explicitNamed) {
            return $this->parameters->get($class)[$name];
        }

        // is there a named value implicitly inherited from the parent class?
        // (there cannot be a positional parent. this is because the unified
        // values are stored by name, not position.)
        $implicitNamed = array_key_exists($name, $parent)
            && !$parent[$name] instanceof UnresolvedParameter
            && !$parent[$name] instanceof DefaultValueParameter;

        if ($implicitNamed) {
            return $parent[$name];
        }

        // is a default value available for the current class?
        if ($rparam->isDefaultValueAvailable()) {
            return new DefaultValueParameter($name, $rparam->getDefaultValue());
        }

        // is a default value available for the parent class?
        $parentDefault = array_key_exists($name, $parent)
            && $parent[$name] instanceof DefaultValueParameter;
        if ($parentDefault) {
            return $parent[$name];
        }

        // param is missing
        return new UnresolvedParameter($name);
    }

    /**
     * Returns the unified constructor params for a class.
     *
     * @param string $class  The class name to return values for.
     * @param array  $parent The parent unified params.
     *
     * @return array The unified params.
     * @throws ReflectionException
     */
    protected function getUnifiedParameters(string $class, array $parent): array
    {
        // reflect on what params to pass, in which order
        $unified = [];
        $rparams = $this->reflector->getParameters($class);
        foreach ($rparams as $rparam) {
            $unified[$rparam->name] = $this->getUnifiedParameter(
                $rparam,
                $class,
                $parent
            );
        }

        return $unified;
    }

    /**
     * Returns the unified setters for a class.
     *
     * Class-specific setters take precendence over trait-based setters, which
     * take precedence over interface-based setters.
     *
     * @param string $class  The class name to return values for.
     * @param array  $parent The parent unified setters.
     *
     * @return array The unified setters.
     */
    protected function getUnifiedSetters(string $class, array $parent): array
    {
        $unified = $parent;
        // look for interface setters
        $interfaces = class_implements($class);
        foreach ($interfaces as $interface) {
            if ($this->setters->has($interface)) {
                $unified = $this->setters->merge($interface, $unified);
            }
        }

        // look for trait setters
        $traits = $this->reflector->getTraits($class);
        foreach ($traits as $trait) {
            if ($this->setters->has($trait)) {
                $unified = $this->setters->merge($trait, $unified);
            }
        }

        // look for class setters
        if ($this->setters->has($class)) {
            $unified = array_merge(
                $unified,
                $this->setters->get($class)
            );
        }

        return $unified;
    }

    /**
     * Expands variadic parameters onto the end of a constructor parameters
     * array.
     *
     * @param Blueprint $blueprint The blueprint to expand parameters for.
     *
     * @return Blueprint The blueprint with expanded constructor parameters.
     * @throws ReflectionException
     */
    protected function expandParameters(Blueprint $blueprint): Blueprint
    {
        $class  = $blueprint->getClassName();
        $params = $blueprint->getParameters();

        $variadicParams = [];
        foreach ($this->reflector->getParameters($class) as $reflectParam) {
            $paramName = $reflectParam->getName();
            if ($reflectParam->isVariadic() && is_array($params[$paramName])) {
                $variadicParams = array_merge($variadicParams, $params[$paramName]);
                unset($params[$paramName]);
                break; // There can only be one
            }

            if ($params[$paramName] instanceof DefaultValueParameter) {
                $params[$paramName] = $params[$paramName]->getValue();
            }
        }

        return $blueprint->replaceParameters(
            array_merge($params, array_values($variadicParams))
        );
    }
}
