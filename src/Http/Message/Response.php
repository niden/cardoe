<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Helper\Number;
use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Phalcon\Http\Message\Traits\CommonTrait;
use Phalcon\Http\Message\Traits\MessageTrait;
use Phalcon\Http\Message\Traits\ResponseTrait;
use Psr\Http\Message\ResponseInterface;

use function is_int;
use function is_string;

/**
 * Representation of an outgoing, server-side response.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - Status code and reason phrase
 * - Headers
 * - Message body
 *
 * Responses are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return an instance that contains the changed state
 */
final class Response implements ResponseInterface
{
    use CommonTrait;
    use MessageTrait;
    use ResponseTrait;

    /**
     * Gets the response reason phrase associated with the status code.
     *
     * Because a reason phrase is not a required element in a response
     * status line, the reason phrase value MAY be empty. Implementations MAY
     * choose to return the default RFC 7231 recommended reason phrase (or
     * those
     * listed in the IANA HTTP Status Code Registry) for the response's
     * status code.
     *
     * @see http://tools.ietf.org/html/rfc7231#section-6
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     *
     * @var string
     */
    private $reasonPhrase = '';

    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @var int
     */
    private $statusCode = 200;

    /**
     * Response constructor.
     *
     * @param string $body
     * @param int    $code
     * @param array  $headers
     */
    public function __construct($body = 'php://memory', int $code = 200, array $headers = [])
    {
        $this->processCode($code);

        $this->headers = $this->processHeaders($headers);
        $this->body    = $this->processBody($body, 'w+b');
    }

    /**
     * Returns the reason phrase
     *
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * Returns the status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Return an instance with the specified status code and, optionally,
     * reason phrase.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated status and reason phrase.
     *
     * @see http://tools.ietf.org/html/rfc7231#section-6
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     *
     * @param int    $code
     * @param string $reasonPhrase
     *
     * @return Response
     */
    public function withStatus($code, $reasonPhrase = ''): Response
    {
        $newInstance = clone $this;

        $newInstance->processCode($code, $reasonPhrase);

        return $newInstance;
    }

    /**
     * Checks if a code is integer or string
     *
     * @param mixed $code
     */
    private function checkCodeType($code): void
    {
        if (!is_int($code) && !is_string($code)) {
            throw new InvalidArgumentException(
                'Invalid status code; it must be an integer or string'
            );
        }
    }

    /**
     * Checks if a code is integer or string
     *
     * @param int $code
     */
    private function checkCodeValue(int $code): void
    {
        if (true !== Number::between($code, 100, 599)) {
            throw new InvalidArgumentException(
                "Invalid status code '" . $code .
                "', (allowed values 100-599)"
            );
        }
    }

    /**
     * Set a valid status code and phrase
     *
     * @param mixed $code
     * @param mixed $phrase
     */
    private function processCode($code, $phrase = ''): void
    {
        $phrases = $this->getPhrases();

        $this->checkCodeType($code);

        $code = (int) $code;
        $this->checkCodeValue($code);

        if (!is_string($phrase)) {
            throw new InvalidArgumentException('Invalid response reason');
        }

        if ('' === $phrase && isset($phrases[$code])) {
            $phrase = $phrases[$code];
        }

        $this->statusCode   = $code;
        $this->reasonPhrase = $phrase;
    }
}
