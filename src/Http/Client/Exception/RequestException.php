<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client\Exception;

use Exception;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use RuntimeException;

class RequestException extends RuntimeException implements RequestExceptionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param string           $message
     * @param RequestInterface $request
     *
     * @param Exception|null   $previous
     */
    public function __construct(
        string $message,
        RequestInterface $request,
        Exception $previous = null
    ) {
        $this->request = $request;

        parent::__construct($message, 0, $previous);
    }

    /**
     * @inheritdoc
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
