<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AuraPHP
 *
 * @link    https://github.com/auraphp/Aura.Di
 * @license https://github.com/auraphp/Aura.Di/blob/4.x/LICENSE
 */

declare(strict_types=1);

namespace Phalcon\Container\Injection;

/**
 * Returns the value of `include` when invoked (thereby including the file).
 *
 * @property string|LazyInterface $file
 */
class LazyInclude implements LazyInterface
{
    /**
     * The file to include.
     *
     * @var string|LazyInterface
     */
    protected $file;

    /**
     * Constructor.
     *
     * @param string|LazyInterface $file The file to include.
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Invokes the closure to include the file.
     *
     * @return mixed The return from the included file, if any.
     */
    public function __invoke()
    {
        return include $this->file;
    }
}
