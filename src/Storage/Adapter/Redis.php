<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Storage\Adapter;

use Cardoe\Factory\Exception as ExceptionAlias;
use Cardoe\Helper\Arr;
use Cardoe\Storage\Exception;
use Cardoe\Storage\SerializerFactory;
use DateInterval;
use function var_dump;

/**
 * Redis adapter
 */
class Redis extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Redis constructor.
     *
     * @param SerializerFactory|null $factory
     * @param array                  $options
     */
    public function __construct(SerializerFactory $factory = null, array $options = [])
    {
        /**
         * Lets set some defaults and options here
         */
        $options["host"]       = Arr::get($options, "host", "127.0.0.1");
        $options["port"]       = (int) Arr::get($options, "port", 6379);
        $options["index"]      = Arr::get($options, "index", 0);
        $options["persistent"] = Arr::get($options, "persistent", false);
        $options["auth"]       = Arr::get($options, "auth", "");
        $options["socket"]     = Arr::get($options, "socket", "");
        $this->prefix          = "ph-reds-";
        $this->options         = $options;

        parent::__construct($factory, $options);
    }

    /**
     * Flushes/clears the cache
     *
     * @return bool
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function clear(): bool
    {
        return $this->getAdapter()->flushDB();
    }

    /**
     * Decrements a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return bool|false|int
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function decrement(string $key, int $value = 1)
    {
        return $this->getAdapter()->decrBy($key, $value);
    }

    /**
     * Reads data from the adapter
     *
     * @param string $key
     *
     * @return bool
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function delete(string $key): bool
    {
        return (bool) $this->getAdapter()->del($key);
    }

    /**
     * Reads data from the adapter
     *
     * @param string $key
     * @param null   $defaultValue
     *
     * @return mixed
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function get(string $key, $defaultValue = null)
    {
        return $this->getUnserializedData(
            $this->getAdapter()->get($key),
            $defaultValue
        );
    }

    /**
     * Returns the already connected adapter or connects to the Redis
     * server(s)
     *
     * @return mixed|\Redis
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function getAdapter()
    {
        if (null === $this->adapter) {
            $options    = $this->options;
            $connection = new \Redis();
            $auth       = $options["auth"];
            $host       = $options["host"];
            $port       = $options["port"];
            $index      = $options["index"];
            $persistent = $options["persistent"];

            if (!$persistent) {
                $result = $connection->connect($host, $port, $this->lifetime);
            } else {
                $persistentid = "persistentid_" . $index;
                $result       = $connection->pconnect($host, $port, $this->lifetime, $persistentid);
            }

            if (!$result) {
                throw new Exception(
                    "Could not connect to the Redisd server [" . $host . ":" . $port . "]"
                );
            }

            if (!empty($auth) && !$connection->auth($auth)) {
                throw new Exception(
                    "Failed to authenticate with the Redis server"
                );
            }

            if ($index > 0 && !$connection->select($index)) {
                throw new Exception(
                    "Redis server selected database failed"
                );
            }

            $connection->setOption(\Redis::OPT_PREFIX, $this->prefix);

            $this->setSerializer($connection);
            $this->adapter = $connection;
        }

        return $this->adapter;
    }

    /**
     * Stores data in the adapter
     *
     * @return array
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function getKeys(): array
    {
        return $this->getAdapter()->keys("*");
    }

    /**
     * Checks if an element exists in the cache
     *
     * @param string $key
     *
     * @return bool
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function has(string $key): bool
    {
        return (bool) $this->getAdapter()->exists($key);
    }

    /**
     * Increments a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return bool|false|int
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function increment(string $key, int $value = 1)
    {
        return $this->getAdapter()->incrBy($key, $value);
    }

    /**
     * Stores data in the adapter
     *
     * @param string                $key
     * @param mixed                 $value
     * @param DateInterval|int|null $ttl
     *
     * @return bool
     * @throws \Exception
     * @throws Exception
     */
    public function set(string $key, $value, $ttl = null): bool
    {
        return $this->getAdapter()->set(
            $key,
            $this->getSerializedData($value),
            $this->getTtl($ttl)
        )
            ;
    }

    /**
     * Checks the serializer. If it is a supported one it is set, otherwise
     * the custom one is set.
     *
     * @param \Redis $connection
     *
     * @throws Exception
     * @throws ExceptionAlias
     */
    private function setSerializer(\Redis $connection)
    {
        $map = [
            "none" => \Redis::SERIALIZER_NONE,
            "php"  => \Redis::SERIALIZER_PHP,
        ];

        /**
         * In case IGBINARY or MSGPACK are not defined for previous versions
         * of Redis
         */
        if (defined("\\Redis::SERIALIZER_IGBINARY")) {
            $map["igbinary"] = constant("\\Redis::SERIALIZER_IGBINARY");
        }

        if (defined("\\Redis::SERIALIZER_MSGPACK")) {
            $map["msgpack"] = constant("\\Redis::SERIALIZER_MSGPACK");
        }

        $serializer = strtolower($this->defaultSerializer);

        if (isset($map[$serializer])) {
            $this->defaultSerializer = "";
            $connection->setOption(\Redis::OPT_SERIALIZER, $map[$serializer]);
        } else {
            $this->initSerializer();
        }
    }
}