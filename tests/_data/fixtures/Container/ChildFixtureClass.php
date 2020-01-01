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
 * @property mixed|null $other
 * @property string     $data
 */
class ChildFixtureClass extends ParentFixtureClass
{
    /**
     * @var mixed
     */
    protected $other;
    /**
     * @var string
     */
    protected $data;

    /**
     * ChildFixtureClass constructor.
     *
     * @param string     $name
     * @param mixed|null $other
     */
    public function __construct(string $name, $other = null)
    {
        parent::__construct($name);
        $this->other = $other;
    }

    /**
     * @return mixed
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }
}
