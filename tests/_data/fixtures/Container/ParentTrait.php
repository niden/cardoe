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

trait ParentTrait
{
    use ChildTrait;

    protected $parent;

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        var_dump($parent);
        $this->parent = $parent;
    }
}
