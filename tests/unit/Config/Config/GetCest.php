<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Config;

use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class GetCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Config :: __get()
     *
     * @author Cameron Hall <me@chall.id.au>
     * @since  2019-06-17
     */
    public function configGetter(UnitTester $I)
    {
        $I->wantToTest('Config - get()');
        $config = $this->getConfig();
        $I->assertEquals(
            $config->database->adapter,
            $this->config['database']['adapter']
        );
    }

    /**
     * Tests Cardoe\Config\Config :: __get()
     *
     * @author Cameron Hall <me@chall.id.au>
     * @since  2019-06-17
     */
    public function configGet(UnitTester $I)
    {
        $I->wantToTest('Config - get()');
        $config = $this->getConfig();
        $I->assertEquals(
            $config->get('database')->get('adapter'),
            $this->config['database']['adapter']
        );
    }
}
