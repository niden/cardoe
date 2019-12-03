<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Security\Password;

use Cardoe\Security\Password;
use InvalidArgumentException;
use UnitTester;

class HashBcryptCest
{
    /**
     * Unit Tests Cardoe\Security\Password :: hashBcrypt()
     *
     * @since  2019-11-30
     */
    public function securityPasswordHashBcrypt(UnitTester $I)
    {
        $I->wantToTest('Security\Password - hashBcrypt()');

        $security = new Password();

        $source = 'Some text';

        $hash   = $security->hashBcrypt($source);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);

        $hash   = $security->hashBcrypt($source, 8);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);

        $salt   = '65VZZKomwoVwW6YRZp7SUQTnPAvP4Ezi';
        $hash   = $security->hashBcrypt($source, 8, $salt);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);
    }

    /**
     * Unit Tests Cardoe\Security\Password :: hashBcrypt() - exception
     *
     * @since  2019-11-30
     */
    public function securityPasswordHashBcryptException(UnitTester $I)
    {
        $I->wantToTest('Security\Password - hashBcrypt() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                "The 'salt' cannot be less than 32 characters"
            ),
            function () {
                $security = new Password();

                $source = 'Some text';
                $salt   = '1234';
                $hash   = $security->hashBcrypt($source, 8, $salt);
            }
        );
    }
}
