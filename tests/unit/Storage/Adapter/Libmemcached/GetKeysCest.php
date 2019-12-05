<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\Unit\Storage\Adapter\Libmemcached;

use Cardoe\Storage\Adapter\Libmemcached;
use Cardoe\Storage\SerializerFactory;
use Cardoe\Test\Fixtures\Traits\LibmemcachedTrait;
use UnitTester;

use function getOptionsLibmemcached;
use function is_array;
use function var_dump;

class GetKeysCest
{
    use LibmemcachedTrait;

    /**
     * Tests Cardoe\Storage\Adapter\Libmemcached :: getKeys()
     *
     * @author Cardoe Team <team@phalcon.io>
     * @since  2019-04-13
     */
    public function storageAdapterLibmemcachedGetKeys(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Libmemcached - getKeys()');

        $serializer = new SerializerFactory();

        $adapter = new Libmemcached(
            $serializer,
            getOptionsLibmemcached()
        );

        $memcachedServerVersions   = $adapter->getAdapter()->getVersion();
        $memcachedServerVersions   = is_array($memcachedServerVersions) ? $memcachedServerVersions : [];
        $memcachedExtensionVersion = phpversion('memcached');

        foreach ($memcachedServerVersions as $server => $memcachedServerVersion) {
            // https://www.php.net/manual/en/memcached.getallkeys.php#123793
            // https://bugs.launchpad.net/libmemcached/+bug/1534062
            if (
                version_compare($memcachedServerVersion, '1.4.23', '>=') &&
                version_compare($memcachedExtensionVersion, '3.0.1', '<')
            ) {
                $I->skipTest(
                    'getAllKeys() does not work in certain Memcached versions'
                );
            }

            // https://github.com/php-memcached-dev/php-memcached/issues/367
            if (version_compare($memcachedServerVersion, '1.5.0', '>=')) {
                $I->skipTest(
                    'getAllKeys() does not work in certain Memcached versions'
                );
            }
        }

        $adapter->clear();

        $adapter->set('key-1', 'test');
        $adapter->set('key-2', 'test');

        $actual = $adapter->getKeys();
        $I->assertEquals(
            [
                'ph-memc-key-1',
                'ph-memc-key-2',
            ],
            $actual
        );
    }
}
