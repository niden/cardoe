<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Autoload;

use Throwable;

/**
 * Cardoe\Autoload\Exception
 *
 * Exceptions thrown in Cardoe\Autoload will use this class
 */
class Exception extends \Exception implements Throwable
{
}
