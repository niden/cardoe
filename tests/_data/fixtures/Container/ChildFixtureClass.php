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
 * @property int|null   $age
 * @property string     $data
 */
class ChildFixtureClass extends ParentFixtureClass
{
    /**
     * @var int
     */
    protected $age;
    /**
     * @var string
     */
    protected $data;

    /**
     * ChildFixtureClass constructor.
     *
     * @param string   $name
     * @param int|null $age
     */
    public function __construct(string $name, int $age = null)
    {
        parent::__construct($name);
        $this->age  = $age;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
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
