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
 * Interface RoleInterface
 *
 * @package Cardoe\Acl
 */
interface RoleInterface
{
    /**
     * Magic method __toString
     */
    public function __toString(): string;

    /**
     * Returns role description
     */
    public function getDescription(): string;

    /**
     * Returns the role name
     */
    public function getName(): string;
}
