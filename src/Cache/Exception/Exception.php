<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Cache\Exception;

use Throwable;

/**
 * Exceptions thrown in Cardoe\Cache will use this class
 */
class Exception extends \Exception implements \Psr\SimpleCache\CacheException, Throwable
{

}
