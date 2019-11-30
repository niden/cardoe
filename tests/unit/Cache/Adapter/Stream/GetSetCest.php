<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Cache\Adapter\Stream;

use Cardoe\Cache\Adapter\Stream;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use UnitTester;
use function file_put_contents;
use function outputDir;
use function sleep;

class GetSetCest
{
    /**
     * Tests Cardoe\Cache\Adapter\Stream :: set()
     *
     * @throws Exception
     * @since  2019-04-24
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function cacheAdapterStreamSet(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - set()');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $data   = 'Cardoe Framework';
        $result = $adapter->set('test-key', $data);
        $I->assertTrue($result);

        $target = outputDir() . 'phstrm-/te/st/-k/';
        $I->amInPath($target);
        $I->openFile('test-key');
        $expected = 's:3:"ttl";i:3600;s:7:"content";s:24:"s:16:"Cardoe Framework";";}';

        $I->seeInThisFile($expected);
        $I->safeDeleteFile($target . 'test-key');
    }

    /**
     * Tests Cardoe\Cache\Adapter\Stream :: get()
     *
     * @throws Exception
     * @since  2019-04-24
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function cacheAdapterStreamGet(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - get()');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $target = outputDir() . 'phstrm-/te/st/-k/';
        $data   = 'Cardoe Framework';
        $result = $adapter->set('test-key', $data);
        $I->assertTrue($result);

        $expected = 'Cardoe Framework';
        $actual   = $adapter->get('test-key');
        $I->assertNotNull($actual);
        $I->assertEquals($expected, $actual);

        $I->safeDeleteFile($target . 'test-key');
    }

    /**
     * Tests Cardoe\Cache\Adapter\Stream :: get() - errors
     *
     * @throws Exception
     * @since  2019-04-24
     *
     * @author Cardoe Team <team@phalcon.io>
     */
    public function cacheAdapterStreamGetErrors(UnitTester $I)
    {
        $I->wantToTest('Cache\Adapter\Stream - get() - errors');

        $serializer = new SerializerFactory();
        $adapter    = new Stream($serializer, ['storageDir' => outputDir()]);

        $target = outputDir() . 'phstrm-/te/st/-k/';

        // Unknown key
        $expected = 'test';
        $actual   = $adapter->get('unknown', 'test');
        $I->assertEquals($expected, $actual);

        // Invalid JSON object
        $result = file_put_contents($target . 'test-key', '{');
        $I->assertNotFalse($result);

        $expected = 'test';
        $actual   = $adapter->get('test-key', 'test');
        $I->assertEquals($expected, $actual);

        // Expiry
        $data   = 'Cardoe Framework';
        $result = $adapter->set('test-key', $data, 1);
        $I->assertTrue($result);

        sleep(2);

        $expected = 'test';
        $actual   = $adapter->get('test-key', 'test');
        $I->assertEquals($expected, $actual);

        $I->safeDeleteFile($target . 'test-key');
    }
}
