<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Html;

/**
 * Class Escaper
 *
 * @property bool   $doubleEncode
 * @property string $encoding
 * @property int    $flags
 */
class Escaper
{
    /**
     * @var bool
     */
    protected bool $doubleEncode = true;

    /**
     * @var string
     */
    protected string $encoding = "utf-8";

    /**
     * ENT_QUOTES | ENT_SUBSTITUTE
     *
     * @var int
     */
    protected int $flags = 11;

    /**
     * Escape HTML attributes
     *
     * @param string $input
     *
     * @return string
     */
    public function attributes(string $input): string
    {
        return $input;
    }

    /**
     * Escape CSS
     *
     * @param string $input
     *
     * @return string
     */
    public function css(string $input): string
    {
        return $input;
    }

    /**
     * Returns whether we will use double encoding or not
     *
     * @return bool
     */
    public function getDoubleEncode(): bool
    {
        return $this->doubleEncode;
    }

    /**
     * Returns the encoding used
     *
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * Get the htmlspecialchars flags
     *
     * @return int
     */
    public function getFlags(): int
    {
        return $this->flags;
    }

    /**
     * Escapes HTML
     *
     * @param mixed $input
     *
     * @return string
     */
    public function html($input): string
    {
        return htmlspecialchars(
            $input,
            $this->flags,
            $this->encoding,
            $this->doubleEncode
        );
    }

    /**
     * Escape JS
     *
     * @param string $input
     *
     * @return string
     */
    public function js(string $input): string
    {
        return $input;
    }

    /**
     * Sets whether we will used double encoding or not
     *
     * @param bool $flag
     *
     * @return Escaper
     */
    public function setDoubleEncode(bool $flag): Escaper
    {
        $this->doubleEncode = $flag;

        return $this;
    }

    /**
     * Sets the encoding to be used
     *
     * @param string $encoding
     *
     * @return Escaper
     */
    public function setEncoding(string $encoding): Escaper
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * Escapes a URL
     *
     * @param string $url
     *
     * @return string
     */
    public function url(string $url): string
    {
        return rawurldecode($url);
    }
}
