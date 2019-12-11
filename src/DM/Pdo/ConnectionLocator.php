<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Cardoe\DM\Pdo;

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
     * @param callable $master A callable to create a default connection.
     * @param array    $read   An array of callables to create read
     *                         connections.
     * @param array    $write  An array of callables to create write
     *                         connections.
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
     * @param string $name The read connection name to return.
     *
     * @return ConnectionInterface
     * @throws Exception\ConnectionNotFound
     */
    public function getRead($name = ''): ConnectionInterface
    {
        return $this->getConnection('read', $name);
    }

    /**
     * Returns a write connection by name; if no name is given, picks a
     * random connection; if no write connections are present, returns the
     * default connection.
     *
     * @param string $name The write connection name to return.
     *
     * @return ConnectionInterface
     * @throws Exception\ConnectionNotFound
     */
    public function getWrite($name = ''): ConnectionInterface
    {
        return $this->getConnection('write', $name);
    }

    /**
     * Sets the default connection factory.
     *
     * @param callable $callable The factory for the connection.
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
     * @param string   $name     The name of the connection.
     * @param callable $callable The factory for the connection.
     *
     * @return ConnectionLocatorInterface
     *
     */
    public function setRead($name, callable $callable): ConnectionLocatorInterface
    {
        $this->read[$name] = $callable;

        return $this;
    }

    /**
     *
     * Sets a write connection factory by name.
     *
     * @param string   $name     The name of the connection.
     * @param callable $callable The factory for the connection.
     *
     * @return ConnectionLocatorInterface
     *
     */
    public function setWrite($name, callable $callable): ConnectionLocatorInterface
    {
        $this->write[$name] = $callable;

        return $this;
    }

    /**
     * Returns a connection by name.
     *
     * @param string $type The connection type ('read' or 'write').
     * @param string $name The name of the connection.
     *
     * @return ConnectionInterface
     * @throws Exception\ConnectionNotFound
     *
     */
    protected function getConnection(string $type, string $name): ConnectionInterface
    {
        if (empty($this->{$type})) {
            return $this->getMaster();
        }

        if ($name === '') {
            $name = array_rand($this->{$type});
        }

        if (!isset($this->{$type}[$name])) {
            throw new Exception\ConnectionNotFound("{$type}:{$name}");
        }

        if (!$this->{$type}[$name] instanceof Connection) {
            $this->{$type}[$name] = call_user_func($this->{$type}[$name]);
        }

        return $this->{$type}[$name];
    }
}
