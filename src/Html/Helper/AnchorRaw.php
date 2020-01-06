<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Html\Helper;

use Phalcon\Html\Exception;

class AnchorRaw extends Anchor
{
    /**
     * Produce a <a> tag without escaping the text
     *
     * @param string $href
     * @param string $text
     * @param array  $attributes
     *
     * @return string
     * @throws Exception
     */
    public function __invoke(
        string $href,
        string $text,
        array $attributes = []
    ): string {
        $overrides = $this->processAttributes($href, $attributes);

        return $this->renderFullElement("a", $text, $overrides, true);
    }
}
