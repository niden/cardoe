<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Storage\Serializer;

use InvalidArgumentException;
use JsonSerializable;

use function is_object;
use function json_decode;
use function json_encode;

/**
 * Class Json
 *
 * @package Cardoe\Storage\Serializer
 */
class Json extends AbstractSerializer
{
    /**
     * Serializes data
     *
     * @return string
     */
    public function serialize()
    {
        if (is_object($this->data) && !($this->data instanceof JsonSerializable)) {
            throw new InvalidArgumentException(
                "Data for JSON serializer cannot be of type object " .
                "without implementing JsonSerializable"
            );
        }

        if (true !== $this->isSerializable($this->data)) {
            return $this->data;
        }

        return json_encode($this->data);
    }

    /**
     * Unserializes data
     *
     * @param string $data
     */
    public function unserialize($data): void
    {
        $this->data = json_decode($data);
    }
}
