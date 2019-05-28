<?php

declare(strict_types=1);

namespace Cardoe\Http\Message\Exception;

use InvalidArgumentException as InvalidArgumentExceptionBase;
use Throwable;

class InvalidArgumentException extends InvalidArgumentExceptionBase implements Throwable
{
}
