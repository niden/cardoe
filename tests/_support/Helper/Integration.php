<?php

namespace Helper;

use Phalcon\DM\Pdo\Connection;
use Phalcon\Test\Fixtures\Migrations\Setup;
use Codeception\TestInterface;

use function date;
use function getenv;
use function sprintf;
use function uniqid;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

/**
 * Class Integration
 *
 * @property string $adapter
 * @property string $password
 * @property string $username
 */
class Integration extends \Codeception\Module
{
    private $adapter    = 'sqlite';
    private $password   = '';
    private $username   = '';

    /**
     * @param TestInterface $test
     */
    public function _before(TestInterface $test)
    {
        $adapter = $test->getMetadata()->getCurrent('env');
        if (!empty($adapter)) {
            $this->adapter = $adapter;
        }

        parent::_before($test);
    }

    /**
     * @return string
     */
    public function getAdapter(): string
    {
        return $this->adapter;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        $connection = new Connection(
            $this->getDatabaseDsn(),
            $this->getDatabaseUsername(),
            $this->getDatabasePassword(),
        );

        //(new Setup())($connection);

        return $connection;
    }

    /**
     * @return string
     */
    public function getDatabaseDsn(): string
    {
        switch ($this->adapter) {
            case 'mysql':
                $this->password = getenv('TEST_MYSQL_PASS');
                $this->username = getenv('TEST_MYSQL_USER');

                return sprintf(
                    "mysql:host=%s;dbname=%s;charset=utf8mb4",
                    getenv('TEST_MYSQL_HOST'),
                    getenv('TEST_MYSQL_NAME')
                );
            case 'postgres':
                $this->password = getenv('TEST_POSTGRES_PASS');
                $this->username = getenv('TEST_POSTGRES_USER');

                return sprintf(
                    "pgsql:host=%s;dbname=%s;user=%s;password=%s",
                    getenv('TEST_POSTGRES_HOST'),
                    getenv('TEST_POSTGRES_NAME'),
                    $this->username,
                    $this->password
                );
            case 'sqlsrv':
                return "";
                break;
            default:
                return "sqlite:memory";
        }
    }

    /**
     * @return string
     */
    public function getDatabasePassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDatabaseUsername(): string
    {
        return $this->username;
    }
}
