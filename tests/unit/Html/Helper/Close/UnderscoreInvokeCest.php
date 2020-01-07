<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Html\Helper\Close;

use Codeception\Example;
use Phalcon\Factory\Exception as ExceptionAlias;
use Phalcon\Html\Escaper;
use Phalcon\Html\Exception;
use Phalcon\Html\Helper\Close;
use Phalcon\Html\TagFactory;
use UnitTester;

class UnderscoreInvokeCest
{
    /**
     * Tests Phalcon\Html\Helper\Close :: __invoke()
     *
     * @since  2020-01-05
     *
     * @param UnitTester $I
     */
    public function htmlHelperCloseUnderscoreInvoke(UnitTester $I)
    {
        $I->wantToTest('Html\Helper\Close - __invoke()');
        $escaper = new Escaper();
        $helper  = new Close($escaper);

        $expected = "</image>";
        $actual   = $helper("image");
        $I->assertEquals($expected, $actual);
    }
}
