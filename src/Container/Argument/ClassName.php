<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Argument;

/**
 * Class ClassName
 *
 * @property string $class
 */
class ClassName implements ClassNameInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * ClassName constructor.
     *
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * Returns the name of the class
     *
     * @return string
     */
    public function get(): string
    {
        return $this->class;
    }
}
