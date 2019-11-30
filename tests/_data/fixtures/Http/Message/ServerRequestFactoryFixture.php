<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\Http\Message;

use Cardoe\Http\Message\ServerRequestFactory;

class ServerRequestFactoryFixture extends ServerRequestFactory
{
    /**
     * Returns the apache_request_headers if it exists
     *
     * @return array|bool
     */
    protected function getHeaders()
    {
        return [
            'Accept-Language' => 'en-us',
            'Accept-Encoding' => 'gzip, deflate',
            'Host'            => 'dev.cardoe.ld',
            'Authorization'   => 'Bearer',
        ];
    }
}
