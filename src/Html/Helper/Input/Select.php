<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Html\Helper\Input;

use Phalcon\Html\Exception;
use Phalcon\Html\Helper\AbstractList;

use function array_unshift;

/**
 * Class Select
 *
 * @property string $elementTag
 */
class Select extends AbstractList
{
    /**
     * @var string
     */
    protected $elementTag = "option";

    /**
     * Add an element to the list
     *
     * @param string      $text
     * @param string|null $value
     * @param array       $attributes
     * @param bool        $raw
     *
     * @return $this
     * @throws Exception
     */
    public function add(
        string $text,
        string $value = null,
        array $attributes = [],
        bool $raw = false
    ) {
        if (null !== $value) {
            $attributes["value"] = $value;
        }

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
     * Add an element to the list
     *
     * @param string $text
     * @param string $value
     * @param array  $attributes
     * @param bool   $raw
     *
     * @return $this
     * @throws Exception
     */
    public function addPlaceholder(
        string $text,
        string $value = null,
        array $attributes = [],
        bool $raw = false
    ) {
        if (null !== $value) {
            $attributes["value"] = $value;
        }

        array_unshift(
            $this->store,
            $this->indent . $this->renderFullElement(
                $this->elementTag,
                $text,
                $attributes,
                $raw
            )
        );

        return $this;
    }
    /**
     * @return string
     */
    protected function getTag(): string
    {
        return "select";
    }
}
