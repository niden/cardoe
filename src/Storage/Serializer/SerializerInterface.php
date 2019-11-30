<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Storage\Serializer;

use Serializable;

/**
 * Interface SerializerInterface
 *
 * @package Cardoe\Storage\Serializer
 */
interface SerializerInterface extends Serializable
{
    /**
     * @var mixed
     */
    public function getData();

    /**
     * @param mixed $data
     */
    public function setData($data): void;
}
