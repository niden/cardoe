<?php

declare(strict_types=1);

/**
* This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Acl\Adapter;

/**
 * Class Adapter
 *
 * @property string|null $activeAccess
 * @property string|null $activeComponent
 * @property string|null $activeRole
 * @property bool        $accessGranted
 * @property int         $defaultAccess
*/
abstract class AbstractAdapter implements AdapterInterface
{
    const ALLOW = 1;
    const DENY  = 0;

    /**
     * Active access which the list is checking if some role can access it
     *
     * @var string|null
     */
    protected $activeAccess = null;

    /**
     * Component which the list is checking if some role can access it
     *
     * @var string|null
     */
    protected $activeComponent;

    /**
     * Role which the list is checking if it's allowed to certain
     * component/access
     *
     * @var string|null
     */
    protected $activeRole;

    /**
     * Access Granted
     *
     * @var bool
     */
    protected $accessGranted = false;

    /**
     * Default access
     *
     * @var int
     */
    protected $defaultAccess = 0;

    /**
     * @return string|null
     */
    public function getActiveAccess(): ?string
    {
        return $this->activeAccess;
    }

    /**
     * @return string|null
     */
    public function getActiveComponent(): ?string
    {
        return $this->activeComponent;
    }

    /**
     * @return string|null
     */
    public function getActiveRole(): ?string
    {
        return $this->activeRole;
    }

    /**
     * Returns the default ACL access level
     */
    public function getDefaultAction(): int
    {
        return $this->defaultAccess;
    }

    /**
     * Sets the default access level (Cardoe\Acl::ALLOW or Cardoe\Acl::DENY)
     *
     * @param int $defaultAccess
     */
    public function setDefaultAction(int $defaultAccess): void
    {
        $this->defaultAccess = $defaultAccess;
    }
}
