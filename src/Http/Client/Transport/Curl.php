<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Transport;

use Cardoe\Http\Client\Exception\Exception;
use Cardoe\Http\Client\Exception\NetworkException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use function array_shift;
use function curl_close;
use function curl_errno;
use function curl_error;
use function curl_exec;
use function curl_init;
use function curl_setopt_array;
use function explode;
use function extension_loaded;
use function fclose;
use function fopen;
use function strlen;
use function trim;
use const CURL_HTTP_VERSION_1_0;
use const CURL_HTTP_VERSION_1_1;
use const CURL_HTTP_VERSION_2_0;
use const CURLOPT_CONNECTTIMEOUT;
use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_FILE;
use const CURLOPT_FOLLOWLOCATION;
use const CURLOPT_HEADER;
use const CURLOPT_HEADERFUNCTION;
use const CURLOPT_HTTP_VERSION;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_POSTFIELDS;
use const CURLOPT_RETURNTRANSFER;

/**
 * Class Curl
 */
class Curl extends AbstractTransport
{
    /**
     * Curl constructor.
     *
     * @param StreamFactoryInterface   $streamFactory
     * @param ResponseFactoryInterface $responseFactory
     * @param array                    $options
     *
     * @throws Exception
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        array $options = []
    ) {
        if (true !== extension_loaded('curl')) {
            throw new Exception(
                'curl extension must be loaded for this transport to work'
            );
        }

        parent::__construct($streamFactory, $responseFactory, $options);
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(RequestInterface $request): ResponseInterface
    {
    }
}
