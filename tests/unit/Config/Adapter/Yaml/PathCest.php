<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Config\Adapter\Yaml;

use Cardoe\Test\Fixtures\Traits\ConfigTrait;
use UnitTester;

class PathCest
{
    use ConfigTrait;

    public function _before(UnitTester $I)
    {
        $I->checkExtensionIsLoaded('yaml');
    }

    /**
     * Tests Cardoe\Config\Adapter\Yaml :: path()
     *
     * @since  2018-11-13
     */
    public function configAdapterYamlPath(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Yaml - path()');

        $this->checkPath($I, 'Yaml');
    }

    /**
     * Tests Cardoe\Config\Adapter\Yaml :: path() - default
     *
     * @since  2018-11-13
     */
    public function configAdapterYamlPathDefault(UnitTester $I)
    {
        $I->wantToTest('Config\Adapter\Yaml - path() - default');

        $this->checkPathDefault($I, 'Yaml');
    }
}
