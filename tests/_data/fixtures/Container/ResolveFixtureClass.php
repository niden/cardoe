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
 * @property string $name
 */
class ParentFixtureClass
{
    /**
     * @var string
     */
    protected $name;

    public function __construct(string $name = 'seven')
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
