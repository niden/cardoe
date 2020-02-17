<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by Zend Diactoros
 * @link    https://github.com/zendframework/zend-diactoros
 * @license https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Helper\Number;
use Phalcon\Helper\Arr;
use Phalcon\Helper\Str;
use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;

use function is_resource;
use function is_string;

/**
 * PSR-7 UploadedFile
 *
 * @property bool                        $alreadyMoved
 * @property string|null                 $clientFilename
 * @property string|null                 $clientMediaType
 * @property int                         $error
 * @property string                      $fileName
 * @property int|null                    $size
 * @property StreamInterface|string|null $stream;
 */
final class UploadedFile implements UploadedFileInterface
{
    /**
     * If the file has already been moved, we hold that status here
     *
     * @var bool
     */
    protected $alreadyMoved = false;

    /**
     * Retrieve the filename sent by the client.
     *
     * Do not trust the value returned by this method. A client could send
     * a malicious filename with the intention to corrupt or hack your
     * application.
     *
     * Implementations SHOULD return the value stored in the 'name' key of
     * the file in the $_FILES array.
     *
     * @var string | null
     */
    protected $clientFilename = null;

    /**
     * Retrieve the media type sent by the client.
     *
     * Do not trust the value returned by this method. A client could send
     * a malicious media type with the intention to corrupt or hack your
     * application.
     *
     * Implementations SHOULD return the value stored in the 'type' key of
     * the file in the $_FILES array.
     *
     * @var string | null
     */
    protected $clientMediaType = null;

    /**
     * Retrieve the error associated with the uploaded file.
     *
     * The return value MUST be one of PHP's UPLOAD_ERR_XXX constants.
     *
     * If the file was uploaded successfully, this method MUST return
     * UPLOAD_ERR_OK.
     *
     * Implementations SHOULD return the value stored in the 'error' key of
     * the file in the $_FILES array.
     *
     * @see http://php.net/manual/en/features.file-upload.errors.php
     *
     * @var int
     */
    protected $error = 0;

    /**
     * If the stream is a string (file name) we store it here
     *
     * @var string
     */
    protected $fileName = "";

    /**
     * Retrieve the file size.
     *
     * Implementations SHOULD return the value stored in the 'size' key of
     * the file in the $_FILES array if available, as PHP calculates this based
     * on the actual size transmitted.
     *
     * @var int | null
     */
    protected $size = null;

    /**
     * Holds the stream/string for the uploaded file
     *
     * @var StreamInterface|string|null
     */
    protected $stream;

    /**
     * UploadedFile constructor.
     *
     * @param StreamInterface|string|null $stream
     * @param int|null                    $size
     * @param int                         $error
     * @param string|null                 $clientFilename
     * @param string|null                 $clientMediaType
     */
    public function __construct(
        $stream,
        int $size = null,
        int $error = 0,
        string $clientFilename = null,
        string $clientMediaType = null
    ) {
        /**
         * Check the stream passed. It can be a string representing a file or
         * a StreamInterface
         */
        $this->checkStream($stream, $error);

        /**
         * Check the error
         */
        $this->checkError($error);

        $this->size            = $size;
        $this->clientFilename  = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    /**
     * @return string|null
     */
    public function getClientFilename(): ?string
    {
        return $this->clientFilename;
    }

    /**
     * @return string|null
     */
    public function getClientMediaType(): ?string
    {
        return $this->clientMediaType;
    }

    /**
     * @return int
     */
    public function getError(): int
    {
        return $this->error;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Retrieve a stream representing the uploaded file.
     *
     * This method MUST return a StreamInterface instance, representing the
     * uploaded file. The purpose of this method is to allow utilizing native
     * PHP stream functionality to manipulate the file upload, such as
     * stream_copy_to_stream() (though the result will need to be decorated in
     * a native PHP stream wrapper to work with such functions).
     *
     * If the moveTo() method has been called previously, this method MUST
     * raise an exception.
     *
     * @return StreamInterface Stream representation of the uploaded file.
     * @throws RuntimeException in cases when no stream is available or can be created.
     */
    public function getStream()
    {
        if (0 !== $this->error) {
            throw new InvalidArgumentException(
                $this->getErrorDescription($this->error)
            );
        }

        if ($this->alreadyMoved) {
            throw new InvalidArgumentException(
                "The file has already been moved to the target location"
            );
        }

        if (!($this->stream instanceof StreamInterface)) {
            $this->stream = new Stream($this->fileName);
        }

        return $this->stream;
    }

    /**
     * Move the uploaded file to a new location.
     *
     * Use this method as an alternative to move_uploaded_file(). This method is
     * guaranteed to work in both SAPI and non-SAPI environments.
     * Implementations must determine which environment they are in, and use the
     * appropriate method (move_uploaded_file(), rename(), or a stream
     * operation) to perform the operation.
     *
     * $targetPath may be an absolute path, or a relative path. If it is a
     * relative path, resolution should be the same as used by PHP's rename()
     * function.
     *
     * The original file or stream MUST be removed on completion.
     *
     * If this method is called more than once, any subsequent calls MUST raise
     * an exception.
     *
     * When used in an SAPI environment where $_FILES is populated, when writing
     * files via moveTo(), is_uploaded_file() and move_uploaded_file() SHOULD be
     * used to ensure permissions and upload status are verified correctly.
     *
     * If you wish to move to a stream, use getStream(), as SAPI operations
     * cannot guarantee writing to stream destinations.
     *
     * @see http://php.net/is_uploaded_file
     * @see http://php.net/move_uploaded_file
     *
     * @param string $targetPath Path to which to move the uploaded file.
     *
     * @throws InvalidArgumentException if the $targetPath specified is invalid.
     * @throws RuntimeException on any error during the move operation, or on
     *     the second or subsequent call to the method.
     */
    public function moveTo($targetPath): void
    {
        if ($this->alreadyMoved) {
            throw new InvalidArgumentException("File has already been moved");
        }

        if (0 !== $this->error) {
            throw new InvalidArgumentException(
                $this->getErrorDescription($this->error)
            );
        }

        /**
         * All together for early failure
         */
        if (
                !(
                    is_string($targetPath) &&
                    !empty($targetPath) &&
                    is_dir(dirname($targetPath)) &&
                    is_writable(dirname($targetPath))
                )
        ) {
            throw new InvalidArgumentException(
                "Target folder is empty string, not a folder or not writable"
            );
        }

        $sapi = constant("PHP_SAPI");

        if (
            empty($sapi) ||
            !empty($this->fileName) ||
            Str::startsWith($sapi, "cli") ||
            Str::startsWith($sapi, "phpdbg")
        ) {
            $this->storeFile($targetPath);
        } else {
            if (true !== move_uploaded_file($this->fileName, $targetPath)) {
                throw new InvalidArgumentException(
                    "The file cannot be moved to the target folder"
                );
            }
        }

        $this->alreadyMoved = true;
    }

    /**
     * Checks the passed error code and if not in the range throws an exception
     *
     * @param int $error
     */
    private function checkError(int $error): void
    {
        if (true !== Number::between($error, 0, 8)) {
            throw new InvalidArgumentException(
                "Invalid error. Must be one of the UPLOAD_ERR_* constants"
            );
        }

        $this->error = $error;
    }

    /**
     * Checks the passed error code and if not in the range throws an exception
     *
     * @param StreamInterface|resource|string $stream
     * @param int                             $error
     */
    private function checkStream($stream, int $error): void
    {
        if (0 === $error) {
            switch (true) {
                case (is_string($stream)):
                    $this->fileName = $stream;
                    break;
                case (is_resource($stream)):
                    $this->stream = new Stream($stream);
                    break;
                case ($stream instanceof StreamInterface):
                    $this->stream = $stream;
                    break;
                default:
                    throw new InvalidArgumentException(
                        "Invalid stream or file passed"
                    );
            }
        }
    }

    /**
     * Returns a description string depending on the upload error code passed
     *
     * @param int $error
     *
     * @return string
     */
    private function getErrorDescription(int $error): string
    {
        $errors = [
            0 => "There is no error, the file uploaded with success.",
            1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
            2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
            3 => "The uploaded file was only partially uploaded.",
            4 => "No file was uploaded.",
            6 => "Missing a temporary folder.",
            7 => "Failed to write file to disk.",
            8 => "A PHP extension stopped the file upload."
        ];

        return Arr::get($errors, $error, "Unknown upload error");
    }

    /**
     * Store a file in the new location (stream)
     *
     * @param string $targetPath
     */
    private function storeFile(string $targetPath): void
    {
        $handle = fopen($targetPath, "w+b");
        if (false === $handle) {
            throw new InvalidArgumentException("Cannot write to file.");
        }

        $stream = $this->getStream();

        $stream->rewind();

        while (true !== $stream->eof()) {
            $data = $stream->read(2048);

            fwrite($handle, $data);
        }

        fclose($handle);
    }
}
