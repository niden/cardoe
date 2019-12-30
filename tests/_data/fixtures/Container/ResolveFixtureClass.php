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
 * Class ResolveFixtureClass
 *
 * @property string $name
 */
class ResolveFixtureClass
{
    /**
     * @var ParentFixtureClass
     */
    public $class;

    public function __construct(ParentFixtureClass $class)
    {
        $this->class = $class;
    }
}
