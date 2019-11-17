<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Integration\DM\Pdo\Connection;

use Cardoe\DM\Pdo\Connection;
use Cardoe\Test\Fixtures\Traits\DM\ConnectionTrait;
use IntegrationTester;

class GetSetLogFormatCest
{
    use ConnectionTrait;

    /**
     * Tests Cardoe\DM\Pdo\Connection :: getLogFormat()/setLogFormat()
     *
     * @since  2019-11-16
     */
    public function connectionGetSetLogFormat(IntegrationTester $I)
    {
        $I->wantToTest('DM\Pdo\Connection - getLogFormat()/setLogFormat()');

        $expected = "[A: %start%][Z: %start%][D: %duration%][S: %statement%]"
            . "[V: %values%]\n[Trace: %trace%]";
        $actual   = $this->connection->getLogFormat();
        $I->assertEquals($expected, $actual);

        $expected = '%start%-%finish%';
        $result   = $this->connection->setLogFormat($expected);
        $I->assertInstanceOf(Connection::class, $result);

        $actual = $this->connection->getLogFormat();
        $I->assertEquals($expected, $actual);
    }
}
