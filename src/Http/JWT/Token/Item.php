<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\JWT\Token;

/**
 * Class Item
 */
class Item extends AbstractItem
{
    /**
     * Item constructor.
     *
     * @param array  $payload
     * @param string $encoded
     */
    public function __construct(array $payload, string $encoded)
    {
        $this->data['encoded'] = $encoded;
        $this->data['payload'] = $payload;
    }

    /**
     * @param string     $name
     * @param mixed|null $defaultValue
     *
     * @return mixed|null
     */
    public function get(string $name, $defaultValue = null)
    {
        if (!$this->has($name)) {
            return $defaultValue;
        }

        return $this->data['payload'][$name];
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->data["payload"];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->data['payload']);
    }
}
