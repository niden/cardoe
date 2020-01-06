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
 * Class AbstractList
 *
 * @property array  $attributes
 * @property string $delimiter
 * @property string $indent
 * @property array  $store
 */
abstract class AbstractList extends AbstractHelper
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $delimiter = PHP_EOL;

    /**
     * @var string
     */
    protected $indent = "    ";

    /**
     * @var array
     */
    protected $store = [];

    /**
     * @param string $indent
     * @param string $delimiter
     * @param array  $attributes
     *
     * @return AbstractList
     */
    public function __invoke(
        string $indent = null,
        string $delimiter = null, // PHP_EOL,
        array $attributes = []
    ): AbstractList {
        $this->attributes = $attributes;
        if (null !== $delimiter) {
            $this->delimiter = $delimiter;
        }

        if (null !== $indent) {
            $this->indent = $indent;
        }

        $this->store = [];

        return $this;
    }

    /**
     * Generates and returns the HTML for the list.
     *
     * @return string
     * @throws Exception
     */
    public function __toString()
    {
        if (empty($this->store)) {
            return "";
        }

        $contents = $this->delimiter
            . implode($this->delimiter, $this->store)
            . $this->delimiter;

        return $this->renderFullElement(
            $this->getTag(),
            $contents,
            $this->attributes,
            true
        );
    }

    /**
     * Add an element to the list
     *
     * @param string $text
     * @param array  $attributes
     *
     * @return $this
     * @throws Exception
     */
    public function add(string $text, array $attributes = [])
    {
        $this->store[] = $this->indent
            . $this->renderFullElement("li", $text, $attributes);

        return $this;
    }

    /**
     * Add a raw element to the list
     *
     * @param string $text
     * @param array  $attributes
     *
     * @return $this
     * @throws Exception
     */
    public function addRaw(string $text, array $attributes = [])
    {
        $this->store[] = $this->indent
            . $this->renderFullElement("li", $text, $attributes, true);

        return $this;
    }

    /**
     *
     * Returns the tag name.
     *
     * @return string
     *
     */
    abstract protected function getTag();
}
