<?php

namespace Helper;

use Cardoe\DM\Pdo\Connection;
use Cardoe\Test\Fixtures\Migrations\Setup;
use Codeception\TestInterface;

use function date;
use function getenv;
use function sprintf;
use function uniqid;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

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

        (new Setup())($connection);

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

    /**
     * @param Connection  $connection
     * @param int         $id
     * @param string|null $title
     *
     * @return int
     */
    public function getNewInvoice(
        Connection $connection,
        int $id,
        string $title = null
    ): int {
        $title = $title ?: uniqid();
        $now   = date('Y-m-d H:i:s');
        $total = 100 + $id;
        $flag  = (int) ($id % 2);
        $sql   = <<<SQL
insert into co_invoices (
    inv_id, 
    inv_cst_id, 
    inv_status_flag, 
    inv_title, 
    inv_total, 
    inv_created_at 
) values (
    {$id}, 
    1, 
    {$flag}, 
    "{$title}", 
    {$total}, 
    "{$now}"
)
SQL;

        return $connection->exec($sql);
    }
}
