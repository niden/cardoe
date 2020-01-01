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

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

/**
 * Class Reflector
 *
 * @property array $classes
 * @property array $parameters
 * @property array $traits
 */
class Reflector
{
    /**
     * Collected ReflectionClass instances.
     *
     * @var array
     */
    protected $classes = [];

    /**
     * Collected arrays of ReflectionParameter instances for class constructors.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Collected traits in classes.
     *
     * @var array
     */
    protected $traits = [];

    /**
     * When serializing, ignore the Reflection-based properties.
     *
     * @return array
     */
    public function __sleep(): array
    {
        return ['traits'];
    }

    /**
     * Returns a ReflectionClass for the given class.
     *
     * @param string $class Return a ReflectionClass for this class.
     *
     * @return ReflectionClass
     * @throws ReflectionException when the class does not exist.
     */
    public function getClass($class): ReflectionClass
    {
        if (!isset($this->classes[$class])) {
            $this->classes[$class] = new ReflectionClass($class);
        }

        return $this->classes[$class];
    }

    /**
     *
     * Returns an array of ReflectionParameter instances for the constructor of
     * a given class.
     *
     * @param string $class Return the array of ReflectionParameter instances
     *                      for the constructor of this class.
     *
     * @return array|ReflectionParameter[]
     * @throws ReflectionException
     */
    public function getParameters($class): array
    {
        if (!isset($this->parameters[$class])) {
            $this->parameters[$class] = [];

            $constructor = $this->getClass($class)->getConstructor();
            if (null !== $constructor) {
                $this->parameters[$class] = $constructor->getParameters();
            }
        }

        return $this->parameters[$class];
    }


    /**
     *
     * Returns all traits used by a class and its ancestors,
     * and the traits used by those traits' and their ancestors.
     *
     * @param string $class The class or trait to look at for used traits.
     *
     * @return array All traits used by the requested class or trait.
     *
     * @todo Make this function recursive so that parent traits are retained
     * in the parent keys.
     *
     */
    public function getTraits($class): array
    {
        if (!isset($this->traits[$class])) {
            $traits = [];

            // get traits from ancestor classes
            do {
                $traits += class_uses($class);
            } while ($class = get_parent_class($class));

            // get traits from ancestor traits
            $traitsToSearch = $traits;
            while (!empty($traitsToSearch)) {
                $newTraits      = class_uses(array_pop($traitsToSearch));
                $traits         += $newTraits;
                $traitsToSearch += $newTraits;
            };

            foreach ($traits as $trait) {
                $traits += class_uses($trait);
            }

            $this->traits[$class] = array_unique($traits);
        }

        return $this->traits[$class];
    }
}
