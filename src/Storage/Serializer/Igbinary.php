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
 * Class Igbinary
 *
 * @package Cardoe\Storage\Serializer
 */
class Igbinary extends AbstractSerializer
{
    /**
     * Serializes data
     *
     * @return string
     */
    public function serialize()
    {
        if (true !== $this->isSerializable($this->data)) {
            return $this->data;
        }

        return igbinary_serialize($this->data);
    }

    /**
     * Unserializes data
     *
     * @param string $data
     */
    public function unserialize($data): void
    {
        $this->data = igbinary_unserialize($data);
    }
}
