<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Middleware;

use Cardoe\Http\Client\Request\HandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function call_user_func;

/**
 * Class Closure
 *
 * @property callable $closure
 */
class Closure implements MiddlewareInterface
{
    /**
     * @var callable
     */
    private $closure;

    /**
     * Closure constructor.
     *
     * @param callable $closure
     */
    public function __construct(callable $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @param RequestInterface $request
     * @param HandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(
        RequestInterface $request,
        HandlerInterface $handler
    ): ResponseInterface {

        return call_user_func($this->closure, $request, $handler);
    }
}
