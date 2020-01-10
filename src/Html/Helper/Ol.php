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

/**
 * Class Ol
 */
class Ol extends AbstractList
{

    /**
     * Add an element to the list
     *
     * @param string $text
     * @param array  $attributes
     * @param bool   $raw
     *
     * @return $this
     * @throws Exception
     */
    public function add(string $text, array $attributes = [], bool $raw = false)
    {
        $this->store[] = $this->indent
            . $this->renderFullElement(
                $this->elementTag,
                $text,
                $attributes,
                $raw
            );

        return $this;
    }

    /**
     * @return string
     */
    protected function getTag(): string
    {
        return 'ol';
    }
}
