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

use ArrayObject;

/**
 * Returns the value of a callable when invoked (thereby invoking the callable).
 */
class LazyArray extends ArrayObject implements LazyInterface
{
    /**
     * Invoke any LazyInterface in the array.
     *
     * @return array The array of potentially invoked items.
     */
    public function __invoke()
    {
        // convert Lazy objects in the callables
        foreach ($this as $key => $val) {
            if ($val instanceof LazyInterface) {
                $this[$key] = $val();
            }
        }

        // return array
        return $this->getArrayCopy();
    }
}
