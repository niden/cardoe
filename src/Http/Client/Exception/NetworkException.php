<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Exception;

use Psr\Http\Client\NetworkExceptionInterface;

/**
 * Class NetworkException
 */
class NetworkException extends RequestException implements NetworkExceptionInterface
{
}
