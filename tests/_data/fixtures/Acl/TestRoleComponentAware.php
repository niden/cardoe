<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Fixtures\Acl;

use Cardoe\Acl\ComponentAware;
use Cardoe\Acl\RoleAware;

/**
 * Class TestRoleComponentAware
 */
class TestRoleComponentAware implements RoleAware, ComponentAware
{
    /**
     * @var int
     */
    protected $user;

    /**
     * @var string
     */
    protected $componentName;

    /**
     * @var string
     */
    protected $roleName;

    public function __construct($user, string $componentName, string $roleName)
    {
        $this->user          = $user;
        $this->componentName = $componentName;
        $this->roleName      = $roleName;
    }

    public function getComponentName(): string
    {
        return $this->componentName;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }
}
