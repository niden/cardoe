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

class OneClass
{
    public $class;
    public $optional;

    public static $staticClass;
    public static $staticData;

    public function __construct(
        TwoClass $class = null,
        string $optional = "default optional"
    ) {
        $this->class    = $class;
        $this->optional = $optional;
    }

    public function setClass(TwoClass $class)
    {
        $this->class = $class;
    }

    public function setOptional(string $optional)
    {
        $this->optional = $optional;
    }

    public static function staticSetClass(TwoClass $class, string $data = "Voyager")
    {
        self::$staticClass = $class;
        self::$staticData  = $data;
    }
}
