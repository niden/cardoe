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
 * Class ParametersFixtureClass
 *
 * @property string $name
 */
class ParametersFixtureClass
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var string|null
     */
    public $empty = 'not null';

    /**
     * @var ParentFixtureClass
     */
    public $class;

    /**
     * ParametersFixtureClass constructor.
     *
     * @param array $data
     * @param mixed $empty
     */
    public function __construct(array $data, $empty)
    {
        $this->data  = $data;
        $this->empty = null;
    }
}
