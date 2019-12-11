<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Exception\Exception;

use IntegrationTester;

class GetPreviousCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Exception\Exception :: getPrevious()
     *
     * @since  2019-12-11
     */
    public function dMPdoExceptionExceptionGetPrevious(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Exception\Exception - getPrevious()');

        $I->skipTest('Need implementation');
    }
}
