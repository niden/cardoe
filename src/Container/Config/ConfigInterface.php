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

namespace Phalcon\Container\Config;

use Phalcon\Container\Container;

/**
 * An interface for a set of Container configuration instructions.
 */
interface ConfigInterface
{
    /**
     * Define params, setters, and services before the Container is locked.
     *
     * @param Container $container The DI container.
     */
    public function define(Container $container): void;

    /**
     * Modify service objects after the Container is locked.
     *
     * @param Container $container The DI container.
     */
    public function modify(Container $container): void;
}
