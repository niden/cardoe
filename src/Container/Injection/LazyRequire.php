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
 * Returns the value of `require` when invoked (thereby requiring the file).
 *
 * @property string|LazyInterface $file
 */
class LazyRequire implements LazyInterface
{
    /**
     * The file to require.
     *
     * @var string|LazyInterface
     */
    protected $file;

    /**
     * Constructor.
     *
     * @param string|LazyInterface $file The file to require.
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Invokes the closure to require the file.
     *
     * @return mixed The return from the required file, if any.
     */
    public function __invoke()
    {
        return require $this->file;
    }
}
