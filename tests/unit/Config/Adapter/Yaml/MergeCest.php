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

class MergeCest
{
    use ConfigTrait;

    /**
     * Tests Cardoe\Config\Adapter\Yaml :: merge()
     *
     * @since  2018-11-13
     */
    public function configAdapterYamlMerge(UnitTester $I)
    {
        $I->wantToTest("Config\Adapter\Yaml - merge()");

        $this->checkMergeException($I, 'Yaml');
    }
}
