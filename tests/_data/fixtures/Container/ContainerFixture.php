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

namespace Phalcon\Test\Fixtures\Container;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use UnexpectedValueException;

/**
 * Class ContainerFixture
 *
 * @property array                   $collection
 * @property ContainerInterface|null $delegate
 */
class ContainerFixture implements ContainerInterface
{
    private $collection = [];

    private $delegate;

    public function __construct(array $services, ContainerInterface $delegate = null)
    {
        $this->collection = $services;
        $this->delegate   = $delegate;
    }

    public function get($id)
    {
        if (isset($this->collection[$id])) {
            if (is_callable($this->collection[$id])) {
                $this->collection[$id] = call_user_func($this->collection[$id], $this);
            }
            return $this->collection[$id];
        }
        if ($this->delegate && $this->delegate->has($id)) {
            return $this->delegate->get($id);
        }

        throw new class extends UnexpectedValueException implements NotFoundExceptionInterface
        {
        };
    }

    public function has($id)
    {
        return isset($this->collection[$id]);
    }
}