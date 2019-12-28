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
 * Class Raw
 *
 * @property mixed $argument
 */
class Raw implements RawInterface
{
    protected $argument;

    /**
     * Raw constructor.
     *
     * @param $argument
     */
    public function __construct($argument)
    {
        $this->argument = $argument;
    }

    /**
     * Returns the raw argument
     *
     * @return mixed
     */
    public function get()
    {
        return $this->argument;
    }
}
