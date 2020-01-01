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

/**
 * Class ParentFixtureClass
 *
 * @property mixed $store
 */
class ParentFixtureClass
{
    /**
     * @var mixed
     */
    protected $store;

    public function __construct($store = 'seven')
    {
        $this->store = $store;
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->store;
    }

    public function mirror(string $mirror): string
    {
        return $mirror;
    }
}
