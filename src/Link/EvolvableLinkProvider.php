<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Link;

use Psr\Link\EvolvableLinkProviderInterface;
use Psr\Link\LinkInterface;

/**
 * Class LinkProvider
 *
 * @package Cardoe\Link
 *
 * @property LinkInterface[] $links
 */
class EvolvableLinkProvider extends LinkProvider implements EvolvableLinkProviderInterface
{
    /**
     * Returns an instance with the specified link included.
     *
     * If the specified link is already present, this method MUST return
     * normally without errors. The link is present if $link is === identical
     * to a link object already in the collection.
     *
     * @param LinkInterface $link
     *   A link object that should be included in this collection.
     *
     * @return static
     */
    public function withLink(LinkInterface $link)
    {
        $key         = $this->getKey($link);
        $newInstance = clone $this;

        $newInstance->links[$key] = $link;

        return $newInstance;
    }

    /**
     * Returns an instance with the specified link removed.
     *
     * If the specified link is not present, this method MUST return normally
     * without errors. The link is present if $link is === identical to a link
     * object already in the collection.
     *
     * @param LinkInterface $link
     *   The link to remove.
     *
     * @return static
     */
    public function withoutLink(LinkInterface $link)
    {
        $key         = $this->getKey($link);
        $newInstance = clone $this;

        unset($newInstance->links[$key]);

        return $newInstance;
    }
}
