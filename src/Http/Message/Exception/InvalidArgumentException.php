<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Message\Exception;

use InvalidArgumentException as InvalidArgumentExceptionBase;
use Throwable;

class InvalidArgumentException extends InvalidArgumentExceptionBase implements Throwable
{
}
