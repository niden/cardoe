<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Integration\DM\Pdo\Exception\MissingParameter;

use IntegrationTester;

class GetCodeCest
{
    /**
     * Integration Tests Cardoe\DM\Pdo\Exception\MissingParameter :: getCode()
     *
     * @since  2019-12-11
     */
    public function dMPdoExceptionMissingParameterGetCode(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Exception\MissingParameter - getCode()');

        $I->skipTest('Need implementation');
    }
}
