<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * (c) Cardoe Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\Helper;

use JsonSerializable;

class JsonFixture implements JsonSerializable
{
    private $data = [];

    public function __construct()
    {
        $this->data["one"] = "two";
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}