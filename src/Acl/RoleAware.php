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
 * Interface RoleAware
 *
 * @package Cardoe\Acl
 */
interface RoleAware
{
    /**
     * Returns role name
     */
    public function getRoleName(): string;
}
