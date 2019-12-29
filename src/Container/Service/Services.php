<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Service;

use ArrayIterator;
use Phalcon\Container\AbstractContainerAware;
use Phalcon\Container\Exception\NotFoundException;
use Traversable;

/**
 * Class Services
 *
 * @property ServiceInterface[] $data
 */
class Services extends AbstractContainerAware implements ServicesInterface
{
    /**
     * @var ServiceInterface[]
     */
    protected $data = [];

    /**
     * Services constructor.
     *
     * @param array $definitions
     */
    public function __construct(array $definitions = [])
    {
        foreach ($definitions as $name => $item) {
            if (is_array($item)) {
                $definition = $item["definition"] ?? null;
                $shared     = $item["shared"] ?? false;
            } else {
                $definition = $item;
                $shared     = false;
            }

            $this->add($name, $definition, $shared);
        }
    }

    /**
     * Adds a definition
     *
     * @param string $name
     * @param mixed  $definition
     * @param bool   $shared
     *
     * @return ServiceInterface
     */
    public function add(string $name, $definition, bool $shared = false): ServiceInterface
    {
        if (!$definition instanceof ServiceInterface) {
            $definition = new Service($name, $definition);
        }

        $this->data[$name] = $definition
            ->setName($name)
            ->setShared($shared)
        ;

        return $definition;
    }

    /**
     * Returns a definition based on its name
     *
     * @param string $name
     *
     * @return ServiceInterface
     */
    public function get(string $name): ServiceInterface
    {
        if ($this->has($name)) {
            $definition = $this->data[$name];
            $definition->setContainer($this->getContainer());

            return $definition;
        }

        throw new NotFoundException(
            sprintf(
                "[%s] is not a registered definition",
                $name
            )
        );
    }

    /**
     * Returns the iterator of the class
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Checks if a definition exists in the internal collection
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Resolves a definition
     *
     * @param string $name
     * @param bool   $isFresh
     *
     * @return mixed
     */
    public function resolve(string $name, bool $isFresh = false)
    {
        return $this->get($name)->resolveService($isFresh);
    }
}
