<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Fixtures\Acl;

use Cardoe\Acl\RoleAware;

/**
 * Class TestRoleAware
 */
class TestRoleAware implements RoleAware
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $roleName;

    public function __construct($id, string $roleName)
    {
        $this->id       = $id;
        $this->roleName = $roleName;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
    }
}
