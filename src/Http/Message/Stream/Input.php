<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\Message\Stream;

use Phalcon\Http\Message\Stream;
use RuntimeException;

use function stream_get_contents;

/**
 * Describes a data stream from "php://input"
 *
 * Typically, an instance will wrap a PHP stream; this interface provides
 * a wrapper around the most common operations, including serialization of
 * the entire stream to a string.
 *
 * @property string $data
 * @property bool   $eof
 */
class Input extends Stream
{
    /**
     * @var string
     */
    private string $data = "";

    /**
     * @var bool
     */
    private bool $eof = false;

    /**
     * Input constructor.
     */
    public function __construct()
    {
        parent::__construct("php://input", "rb");
    }

    /**
     * Reads all data from the stream into a string, from the beginning to end.
     *
     * This method MUST attempt to seek to the beginning of the stream before
     * reading data and read the stream until the end is reached.
     *
     * Warning: This could attempt to load a large amount of data into memory.
     *
     * This method MUST NOT raise an exception in order to conform with PHP's
     * string casting operations.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     */
    public function __toString(): string
    {
        if ($this->eof) {
            return $this->data;
        }

        $this->getContents();

        return $this->data;
    }

    /**
     * Returns the remaining contents in a string
     *
     * @param int $length
     *
     * @return string
     * @throws RuntimeException if unable to read.
     * @throws RuntimeException if error occurs while reading.
     *
     */
    public function getContents(int $length = -1): string
    {
        if ($this->eof) {
            return $this->data;
        }

        $data       = stream_get_contents($this->handle, $length);
        $this->data = $data;

        if (-1 === $length || $this->eof()) {
            $this->eof = true;
        }

        return $this->data;
    }

    /**
     * Returns whether or not the stream is writeable.
     */
    public function isWritable(): bool
    {
        return false;
    }

    /**
     * Read data from the stream.
     *
     * @param int $length
     *
     * @return string
     */
    public function read($length): string
    {
        $data = parent::read($length);

        if (true !== $this->eof) {
            $this->data = $data;
        }

        if ($this->eof()) {
            $this->eof = true;
        }

        return $data;
    }
}
