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

class HashCest
{
    /**
     * Unit Tests Cardoe\Security\Password :: hash()
     *
     * @since  2019-11-30
     */
    public function securityPasswordHash(UnitTester $I)
    {
        $I->wantToTest('Security\Password - hash()');

        $security = new Password();

        $source = 'Some text';

        $hash   = $security->hash($source);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);

        $hash   = $security->hash($source, Password::ALGO_DEFAULT);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);

        $options  = [
            'cost' => 10,
            'salt' => '65VZZKomwoVwW6YRZp7SUQTnPAvP4Ezi',
        ];

        $hash   = $security->hash(
            $source,
            Password::ALGO_DEFAULT,
            $options
        );
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);
    }

    /**
     * Unit Tests Cardoe\Security\Password :: hash() - exception
     *
     * @since  2019-11-30
     */
    public function securityPasswordHashException(UnitTester $I)
    {
        $I->wantToTest('Security\Password - hash() - exception');

        $I->expectThrowable(
            new InvalidArgumentException(
                "The 'salt' cannot be less than 32 characters"
            ),
            function () {
                $security = new Password();
                $source   = 'Some text';
                $options  = [
                    'salt' => '1234',
                ];

                $hash = $security->hash(
                    $source,
                    Password::ALGO_DEFAULT,
                    $options
                );
            }
        );
    }
}
