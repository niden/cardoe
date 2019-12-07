<?php

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Message\Stream;

use Cardoe\Http\Message\Stream;
use RuntimeException;

/**
 * Describes a data stream from "php://input"
 *
 * Typically, an instance will wrap a PHP stream; this interface provides
 * a wrapper around the most common operations, including serialization of
 * the entire stream to a string.
 */
class Input extends Stream
{
    /**
     * @var string
     */
    private $data = '';

    /**
     * @var bool
     */
    private $eof = false;

    /**
     * Input constructor.
     */
    public function __construct()
    {
        parent::__construct('php://input', 'rb');
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
        if (true === $this->eof) {
            return $this->data;
        }

        $this->getContents();

        return $this->data;
    }

    /**
     * Returns the remaining contents in a string
     *
     * @throws RuntimeException if unable to read.
     * @throws RuntimeException if error occurs while reading.
     *
     * @param int $length
     *
     * @return string
     */
    public function getContents(int $length = -1): string
    {
        if (true === $this->eof) {
            return $this->data;
        }

        $data = stream_get_contents($this->handle, $length);
        $data = false !== $data ? $data : '';

        $this->data = $data;

        if (-1 === $length || true === $this->eof()) {
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

        if (true === $this->eof()) {
            $this->eof = true;
        }

        return $data;
    }
}
