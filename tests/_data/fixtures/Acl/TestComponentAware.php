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

/**
 * Class TestComponentAware
 */
class TestComponentAware implements ComponentAware
{
    /**
     * @var int
     */
    protected $user;

    /**
     * @var string
     */
    protected $resourceName;

    public function __construct($user, string $resourceName)
    {
        $this->user         = $user;
        $this->resourceName = $resourceName;
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getComponentName(): string
    {
        return $this->resourceName;
    }
}
