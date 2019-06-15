<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Logger\AdapterFactory;

use Cardoe\Factory\Exception;
use function outputDir;
use Cardoe\Logger\Adapter\AdapterInterface;
use Cardoe\Logger\AdapterFactory;
use UnitTester;

class NewInstanceCest
{
    /**
     * Tests Cardoe\Logger\AdapterFactory :: newInstance()
     *
     * @since  2019-05-20
     */
    public function loggerAdapterFactoryNewInstance(UnitTester $I)
    {
        $I->wantToTest('Logger\AdapterFactory - newInstance()');

        $fileName = $I->getNewFileName();
        $fileName = outputDir('tests/logs/' . $fileName);
        $factory = new AdapterFactory();

        $logger = $factory->newInstance('stream', $fileName);
        $I->assertInstanceOf(AdapterInterface::class, $logger);
    }

    /**
     * Tests Cardoe\Logger\AdapterFactory :: newInstance() - exception
     *
     * @since  2019-05-20
     */
    public function loggerAdapterFactoryNewInstanceException(UnitTester $I)
    {
        $I->wantToTest('Logger\AdapterFactory - newInstance() - exception');

        $factory = new AdapterFactory();
        $I->expectThrowable(
            new Exception('Service unknown is not registered'),
            function () use ($factory) {
                $logger = $factory->newInstance('unknown', '123.log');
            }
        );
    }
}
