<?php

declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Client\Transport;

use Cardoe\Helper\Arr;
use Cardoe\Http\Client\AbstractCommon;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class AbstractTransport
 *
 * @propety StreamFactoryInterface   $streamFactory
 * @propety ResponseFactoryInterface $responseFactory
 * @propety array                    $options
 */
abstract class AbstractTransport extends AbstractCommon implements TransportInterface
{
    /**
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param StreamFactoryInterface   $streamFactory
     * @param ResponseFactoryInterface $responseFactory
     * @param array                    $options
     */
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        array $options = []
    ) {
        $this->streamFactory   = $streamFactory;
        $this->responseFactory = $responseFactory;

        $data = [
            'follow'  => (bool) Arr::get($options, 'follow', false),
            'timeout' => (float) Arr::get($options, 'timeout', 10.0),
        ];

        $this->options = $data;
    }
}
