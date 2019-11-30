<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Logger;

use function is_array;

/**
 * Cardoe\Logger\Item
 *
 * Represents each item in a logging transaction
 *
 */
class Item
{
    /**
     * @var array
     */
    protected $context;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $time;

    /**
     * @var integer
     */
    protected $type;

    /**
     * Item constructor.
     *
     * @param string     $message
     * @param string     $name
     * @param int        $type
     * @param int        $time
     * @param array|null $context
     */
    public function __construct(
        string $message,
        string $name,
        int $type,
        int $time = 0,
        $context = null
    ) {
        $this->message = $message;
        $this->name    = $name;
        $this->type    = $type;
        $this->time    = $time;

        if (is_array($context)) {
            $this->context = $context;
        }
    }

    /**
     * @return array|null
     */
    public function getContext(): ?array
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}
