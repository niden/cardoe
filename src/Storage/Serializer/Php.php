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
 * Class Php
 *
 * @package Cardoe\Storage\Serializer
 */
class Php extends AbstractSerializer
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

        return serialize($this->data);
    }

    /**
     * Unserializes data
     *
     * @param string $data
     */
    public function unserialize($data): void
    {
        if (true !== $this->isSerializable($data)) {
            $this->data = $data;
        } else {
            $this->data = unserialize($data);
        }
    }
}
