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
use UnitTester;

class HashArgon2idCest
{
    /**
     * Unit Tests Cardoe\Security\Password :: hashArgon2id()
     *
     * @since  2019-11-30
     */
    public function securityPasswordHashArgon2id(UnitTester $I)
    {
        $I->wantToTest('Security\Password - hashArgon2id()');

        $security = new Password();

        $source = 'Some text';

        $hash   = $security->hashArgon2id($source);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);

        $hash   = $security->hashArgon2id($source, 102400);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);

        $hash   = $security->hashArgon2id($source, 102400, 8);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);

        $hash   = $security->hashArgon2id($source, 102400, 8, 4);
        $result = $security->verify($source, $hash);
        $I->assertTrue($result);
    }
}
