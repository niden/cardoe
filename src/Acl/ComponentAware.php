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
 * Interface ComponentAware
 *
 * @package Cardoe\Acl
 */
interface ComponentAware
{
    /**
     * Returns component name
     */
    public function getComponentName(): string;
}
