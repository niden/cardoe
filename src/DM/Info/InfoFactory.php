<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\DM\Info;

use Cardoe\DM\Info\Adapter\AdapterInterface;
use Cardoe\DM\Info\Adapter\MysqlAdapter;
use Cardoe\DM\Info\Adapter\PgsqlAdapter;
use Cardoe\DM\Info\Adapter\SqliteAdapter;
use Cardoe\DM\Info\Adapter\SqlsrvAdapter;
use Cardoe\DM\Pdo\Connection;
use Cardoe\Factory\AbstractFactory;
use Cardoe\Factory\Exception as FactoryException;

/**
 * Class AdapterFactory
 *
 * @property Connection $connection
 */
class InfoFactory extends AbstractFactory
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * InfoFactory constructor.
     *
     * @param Connection $connection
     * @param array      $services
     */
    public function __construct(Connection $connection, array $services = [])
    {
        $this->connection = $connection;
        $this->init($services);
    }

    /**
     * Create a new instance of the adapter
     *
     * @param string $name
     * @param string $fileName
     * @param array  $options
     *
     * @return AdapterInterface
     * @throws FactoryException
     */
    public function newInstance(
        string $name,
        string $fileName,
        array $options = []
    ): AdapterInterface {
        $this->checkService($name);

        if (true !== isset($this->services[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition($this->connection);
        }

        return $this->services[$name];
    }

    /**
     * @return array
     */
    protected function getAdapters(): array
    {
        return [
            "mysql"  => MysqlAdapter::class,
            "sqlite" => SqliteAdapter::class,
            "sqlsrv" => SqlsrvAdapter::class,
            "pgsql"  => PgsqlAdapter::class,
        ];
    }
}
