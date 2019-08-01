<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

final class UriFactory implements UriFactoryInterface
{
    /**
     * Returns a Locator object with all the helpers defined in anonymous
     * functions
     *
     * @param string $uri
     *
     * @return UriInterface
     */
    public function createUri(string $uri = ''): UriInterface
    {
        return new Uri($uri);
    }
}
