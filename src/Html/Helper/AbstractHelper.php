<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Html\Helper;

use Phalcon\Html\Escaper;
use Phalcon\Html\Exception;

/**
 * Class AbstractHelper
 *
 * @property Escaper $escaper
 */
abstract class AbstractHelper
{
    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * AbstractHelper constructor.
     *
     * @param Escaper $escaper
     */
    public function __construct(Escaper $escaper)
    {
        $this->escaper = $escaper;
    }

    /**
     * Produces a closing tag
     *
     * @param string $tag
     * @param bool   $raw
     *
     * @return string
     */
    protected function close(string $tag, bool $raw = false): string
    {
        $tag = $raw ? $tag : $this->escaper->html($tag);

        return "</" . $tag . ">";
    }
    /**
     * Keeps all the attributes sorted - same order all the tome
     *
     * @param array $overrides
     * @param array $attributes
     *
     * @return array
     */
    protected function orderAttributes(array $overrides, array $attributes): array
    {
        $order = [
            "rel"    => null,
            "type"   => null,
            "for"    => null,
            "src"    => null,
            "href"   => null,
            "action" => null,
            "id"     => null,
            "name"   => null,
            "value"  => null,
            "class"  => null,
        ];

        $intersect = array_intersect_key($order, $attributes);
        $results   = array_merge($intersect, $attributes);
        $results   = array_merge($overrides, $results);

        /**
         * Just in case remove the "escape" attribute
         */
        unset($results["escape"]);

        return $results;
    }

    /**
     * Renders all the attributes
     *
     * @param array $attributes
     *
     * @return string
     */
    protected function renderAttributes(array $attributes): string
    {
        $result = "";
        foreach ($attributes as $key => $value) {
            if (is_string($key) && null !== $value) {
                $result .= $key . "=\"" . $this->escaper->attributes($value) . "\" ";
            }
        }

        return $result;
    }

    /**
     * Renders an element
     *
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     * @throws Exception
     */
    protected function renderElement(string $tag, array $attributes = []): string
    {
        return $this->renderTag($tag, $attributes);
    }

    /**
     * Renders an element
     *
     * @param string $tag
     * @param string $text
     * @param array  $attributes
     * @param bool   $raw
     *
     * @return string
     * @throws Exception
     */
    protected function renderFullElement(
        string $tag,
        string $text,
        array $attributes = [],
        bool $raw = false
    ): string {
        $content = $raw ? $text : $this->escaper->html($text);

        return $this->renderElement($tag, $attributes) . $content . $this->close($tag, $raw);
    }

    /**
     * Renders a tag
     *
     * @param string $tag
     * @param array  $attributes
     * @param string $close
     *
     * @return string
     */
    protected function renderTag(string $tag, array $attributes = [], string $close = ""): string
    {
        $escapedAttrs = "";
        if (count($attributes) > 0) {
            $attrs        = $this->orderAttributes([], $attributes);
            $escapedAttrs = " " . rtrim($this->renderAttributes($attrs));
        }

        $close = empty(trim($close)) ? '' : " " . trim($close);

        return "<" . $tag . $escapedAttrs . $close . ">";
    }

    /**
     * Produces a self close tag i.e. <img />
     *
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    protected function selfClose(string $tag, array $attributes = []): string
    {
        return $this->renderTag($tag, $attributes, "/");
    }
}
