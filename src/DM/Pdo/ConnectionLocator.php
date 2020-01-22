<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\DM\Pdo;

use Phalcon\DM\Pdo\Connection\ConnectionInterface;
use Phalcon\DM\Pdo\Exception\ConnectionNotFound;
use function array_rand;
use function call_user_func;

/**
 * Manages Connection instances for default, read, and write connections.
 *
 * @property callable $master
 * @property array    $read
 * @property array    $write
 */
class ConnectionLocator implements ConnectionLocatorInterface
{
    /**
     * A default Connection connection factory/instance.
     *
     * @var callable
     */
    protected $master;

    /**
     * A registry of Connection "read" factories/instances.
     *
     * @var array
     */
    protected $read = [];

    /**
     * A registry of Connection "write" factories/instances.
     *
     * @var array
     */
    protected $write = [];

    /**
     * Constructor.
     *
     * @param callable|null $master
     * @param array         $read
     * @param array         $write
     */
    public function __construct(
        callable $master = null,
        array $read = [],
        array $write = []
    ) {
        if ($master) {
            $this->setMaster($master);
        }
        foreach ($read as $name => $callable) {
            $this->setRead($name, $callable);
        }
        foreach ($write as $name => $callable) {
            $this->setWrite($name, $callable);
        }
    }

    /**
     * Returns the default connection object.
     *
     * @return ConnectionInterface
     */
    public function getMaster(): ConnectionInterface
    {
        if (!$this->master instanceof Connection) {
            $this->master = call_user_func($this->master);
        }

        return $this->master;
    }

    /**
     * Returns a read connection by name; if no name is given, picks a
     * random connection; if no read connections are present, returns the
     * default connection.
     *
     * @param string $name
     *
     * @return ConnectionInterface
     * @throws ConnectionNotFound
     */
    public function getRead($name = ""): ConnectionInterface
    {
        return $this->getConnection("read", $name);
    }

    /**
     * Returns a write connection by name; if no name is given, picks a
     * random connection; if no write connections are present, returns the
     * default connection.
     *
     * @param string $name
     *
     * @return ConnectionInterface
     * @throws ConnectionNotFound
     */
    public function getWrite($name = ""): ConnectionInterface
    {
        return $this->getConnection("write", $name);
    }

    /**
     * Sets the default connection factory.
     *
     * @param callable|null $callable
     *
     * @return ConnectionLocatorInterface
     */
    public function setMaster(callable $callable): ConnectionLocatorInterface
    {
        $this->master = $callable;

        return $this;
    }

    /**
     * Sets a read connection factory by name.
     *
     * @param string   $name
     * @param callable $callable
     *
     * @return ConnectionLocatorInterface
     */
    public function setRead(
        string $name,
        callable $callable
    ): ConnectionLocatorInterface {
        $this->read[$name] = $callable;

        return $this;
    }

    /**
     * Sets a write connection factory by name.
     *
     * @param string   $name
     * @param callable $callable
     *
     * @return ConnectionLocatorInterface
     */
    public function setWrite(
        string $name,
        callable $callable
    ): ConnectionLocatorInterface {
        $this->write[$name] = $callable;

        return $this;
    }

    /**
     * Returns a connection by name.
     *
     * @param string $type
     * @param string $name
     *
     * @return ConnectionInterface
     * @throws Exception\ConnectionNotFound
     *
     */
    protected function getConnection(
        string $type,
        string $name
    ): ConnectionInterface {
        if (empty($this->{$type})) {
            return $this->getMaster();
        }

        if ($name === '') {
            $name = array_rand($this->{$type});
        }

        if (!isset($this->{$type}[$name])) {
            throw new ConnectionNotFound(
                "Connection not found: " . $type . ":" . $name
            );
        }

        if (!$this->{$type}[$name] instanceof Connection) {
            $this->{$type}[$name] = call_user_func($this->{$type}[$name]);
        }

        return $this->{$type}[$name];
    }
}
