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
 * Class Role
 *
 * @package Cardoe\Acl
 */
class Role implements RoleInterface
{
    /**
     * Role name
     *
     * @var string
     */
    private $name;

    /**
     * Role description
     *
     * @var string
     */
    private $description;

    /**
     * Cardoe\Acl\Role constructor
     */
    /**
     * Role constructor.
     *
     * @param string $name
     * @param string $description
     *
     * @throws Exception
     */
    public function __construct(string $name, string $description = '')
    {
        if ("*" === $name) {
            throw new Exception("Role name cannot be '*'");
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
