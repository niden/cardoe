<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client\Middleware\Cookie;

use Cardoe\Http\Client\Middleware\MiddlewareInterface;
use Cardoe\Http\Client\Request\HandlerInterface;
use Dflydev\FigCookies\SetCookies;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CookieResponse implements MiddlewareInterface
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @inheritdoc
     */
    public function process(
        RequestInterface $request,
        HandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);

        foreach (SetCookies::fromResponse($response)->getAll() as $setCookie) {
            $this->storage->add($setCookie);
        }

        return $response;
    }
}
