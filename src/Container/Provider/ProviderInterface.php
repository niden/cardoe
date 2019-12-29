<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Container\Service;

use Phalcon\Container\ContainerAwareInterface;

interface ProviderInterface extends ContainerAwareInterface
{
    public function define();
    public function modify();
}
