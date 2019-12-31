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

trait ChildTrait
{
    use GrandChildTrait;

    protected $child;

    public function getChild()
    {
        return $this->child;
    }
    public function setChild($child)
    {
        $this->child = $child;
    }
}
