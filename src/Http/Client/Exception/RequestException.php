<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Exception;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use RuntimeException;

/**
 * Class RequestException
 *
 * @property RequestInterface $request
 */
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
     * @param \Exception|null   $previous
     */
    public function __construct($message, RequestInterface $request, \Exception $previous = null)
    {
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
