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

namespace Phalcon\Config\Adapter;

use Phalcon\Config;
use Phalcon\Helper\Json as JsonHelper;

use function file_get_contents;

class Json extends Config
{
    /**
     * Json constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        parent::__construct(
            JsonHelper::decode(
                file_get_contents($filePath),
                true
            )
        );
    }
}
