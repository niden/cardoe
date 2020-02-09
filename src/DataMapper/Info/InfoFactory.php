<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\DataMapper\Info;

use Phalcon\DataMapper\Pdo\Connection\ConnectionInterface;
use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception as FactoryException;

/**
 * Class AdapterFactory
 *
 * @property ConnectionInterface $connection
 */
class InfoFactory extends AbstractFactory
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * InfoFactory constructor.
     *
     * @param ConnectionInterface $connection
     * @param array               $services
     */
    public function __construct(
        ConnectionInterface $connection,
        array $services = []
    ) {
        $this->connection = $connection;
        $this->init($services);
    }

    /**
     * Create a new instance of the adapter
     *
     * @param string $name
     *
     * @return ConnectionInterface
     * @throws FactoryException
     */
    public function newInstance(string $name): ConnectionInterface
    {
        $this->checkService($name);

        $definition = $this->mapper[$name];

        return new $definition($this->connection);
    }

    /**
     * @return array
     */
    protected function getAdapters(): array
    {
        return [
            "mysql"  => "Phalcon\\DataMapper\\Info\\Adapter\\MysqlAdapter",
            "pgsql"  => "Phalcon\\DataMapper\\Info\\Adapter\\PgsqlAdapter",
            "sqlite" => "Phalcon\\DataMapper\\Info\\Adapter\\SqliteAdapter",
            "sqlsrv" => "Phalcon\\DataMapper\\Info\\Adapter\\SqlsrvAdapter",
        ];
    }
}
