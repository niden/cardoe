<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Storage\Serializer;

/**
 * Class Msgpack
 *
 * @package Cardoe\Storage\Serializer
 */
class Msgpack extends AbstractSerializer
{
    /**
     * Serializes data
     *
     * @return string|null
     */
    public function serialize()
    {
        if (true !== $this->isSerializable($this->data)) {
            return $this->data;
        }

        return msgpack_pack($this->data);
    }

    /**
     * Unserializes data
     *
     * @param string $data
     */
    public function unserialize($data): void
    {
        $this->data = msgpack_unpack($data);
    }
}
