<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Acl;

/**
 * Class Component
 *
 * @package Cardoe\Acl
 */
class Component implements ComponentInterface
{
    /**
     * Component name
     *
     * @var string
     */
    private $name;

    /**
     * Component description
     *
     * @var string
     */
    private $description;

    /**
     * Cardoe\Acl\Component constructor
     */
    /**
     * Component constructor.
     *
     * @param string $name
     * @param string $description
     *
     * @throws Exception
     */
    public function __construct(string $name, string $description = '')
    {
        if ("*" === $name) {
            throw new Exception("Component name cannot be '*'");
        }

        $this->name        = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
