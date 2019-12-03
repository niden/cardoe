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

class InfoCest
{
    /**
     * Unit Tests Cardoe\Security\Password :: info()
     *
     * @since  2019-11-30
     */
    public function securityPasswordInfo(UnitTester $I)
    {
        $I->wantToTest('Security\Password - info()');

        $security = new Password();

        $source = 'Some text';

        $hash   = $security->hashArgon2id($source);
        $info   = $security->info($hash);
        $result = [
            'algo'     => 3,
            'algoName' => 'argon2id',
            'options'  => [
                'memory_cost' => 65536,
                'time_cost'   => 4,
                'threads'     => 1,
            ],
        ];
        $I->assertEquals($result, $info);
    }
}
