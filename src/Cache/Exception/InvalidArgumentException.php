<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cache\Exception;

use Throwable;

/**
 * Exceptions thrown in Phalcon\Cache will use this class
 */
class InvalidArgumentException extends \Exception implements \Psr\SimpleCache\InvalidArgumentException, Throwable
{

}
