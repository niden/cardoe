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
     * @var mixed
     */
    protected $data;

    /**
     * ChildFixtureClass constructor.
     *
     * @param string     $store
     * @param mixed|null $other
     */
    public function __construct(string $store, $other = null)
    {
        parent::__construct($store);
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
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
