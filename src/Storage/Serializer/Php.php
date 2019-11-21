<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Storage\Serializer;

use InvalidArgumentException;
use function is_string;
use function restore_error_handler;
use function serialize;
use function set_error_handler;
use function unserialize;
use const E_NOTICE;

/**
 * Class Php
 *
 * @package Cardoe\Storage\Serializer
 */
class Php extends AbstractSerializer
{
    /**
     * @var bool
     */
    private $warning = false;

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
        if (false === $this->isSerializable($data)) {
            $this->data = $data;
        } else {
            if (!is_string($data)) {
                throw new InvalidArgumentException(
                    "Data for the unserializer must of type string"
                );
            }

            $this->warning = false;
            set_error_handler(
                function ($number, $message, $file, $line, $context) {
                    $this->warning = true;
                },
                E_NOTICE
            );

            $this->data = unserialize($data);

            restore_error_handler();

            if ($this->warning) {
                $this->data = null;
            }
        }
    }
}
