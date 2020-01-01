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

use stdClass;

/**
 * Class VariadicFixtureClass
 *
 * @property string $name
 * @property mixed  $items
 */
class VariadicFixtureClass
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var stdClass[]
     */
    protected $items;

    public function __construct(string $name, stdClass ...$items)
    {
        $this->name  = $name;
        $this->items = $items;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItems()
    {
        return $this->items;
    }
}