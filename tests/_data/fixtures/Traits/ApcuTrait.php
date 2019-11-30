<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Fixtures\Traits;

use UnitTester;

trait ApcuTrait
{
    public function _before(UnitTester $I)
    {
        $I->checkExtensionIsLoaded('apcu');
    }
}
