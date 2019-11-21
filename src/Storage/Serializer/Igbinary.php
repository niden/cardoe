<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Storage\Serializer;

use function igbinary_serialize;
use function igbinary_unserialize;
use function restore_error_handler;
use function set_error_handler;
use const E_WARNING;

/**
 * Class Igbinary
 *
 * @package Cardoe\Storage\Serializer
 */
class Igbinary extends AbstractSerializer
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

        return igbinary_serialize($this->data);
    }

    /**
     * Unserializes data
     *
     * @param string $data
     */
    public function unserialize($data): void
    {
        $this->warning = false;
        set_error_handler(
            function ($number, $message, $file, $line, $context) {
                $this->warning = true;
            },
            E_WARNING
        );

        $this->data = igbinary_unserialize($data);

        restore_error_handler();

        if ($this->warning) {
            $this->data = null;
        }
    }
}
