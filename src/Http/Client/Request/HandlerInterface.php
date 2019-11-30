<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client\Request;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HandlerInterface
{
    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface;
}
