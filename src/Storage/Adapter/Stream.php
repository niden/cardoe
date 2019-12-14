<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Storage\Adapter;

use Phalcon\Factory\Exception as ExceptionAlias;
use Phalcon\Helper\Arr;
use Phalcon\Helper\Str;
use Phalcon\Storage\Exception;
use Phalcon\Storage\SerializerFactory;
use DateInterval;
use FilesystemIterator;
use Iterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use function str_replace;
use function strrchr;

/**
 * Stream adapter
 *
 * @property string $storageDir
 * @property array  $options
 * @property bool   $warning
 */
class Stream extends AbstractAdapter
{
    /**
     * @var string
     */
    protected $storageDir = "";

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var bool
     */
    private $warning = false;

    /**
     * Stream constructor.
     *
     * @param SerializerFactory|null $factory
     * @param array                  $options
     *
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function __construct(SerializerFactory $factory = null, array $options = [])
    {
        $storageDir = Arr::get($options, "storageDir", "");
        if (empty($storageDir)) {
            throw new Exception(
                "The 'storageDir' must be specified in the options"
            );
        }

        /**
         * Lets set some defaults and options here
         */
        $this->storageDir = Str::dirSeparator($storageDir);
        $this->prefix     = "ph-strm";
        $this->options    = $options;

        parent::__construct($factory, $options);

        $this->initSerializer();
    }

    /**
     * Flushes/clears the cache
     */
    public function clear(): bool
    {
        $result    = true;
        $directory = Str::dirSeparator($this->storageDir);
        $iterator  = $this->getIterator($directory);

        foreach ($iterator as $file) {
            if ($file->isFile() && !unlink($file->getPathName())) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Decrements a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return bool|int
     * @throws \Exception
     */
    public function decrement(string $key, int $value = 1)
    {
        if (!$this->has($key)) {
            return false;
        }

        $data = $this->get($key);
        $data = (int) $data - $value;

        return $this->set($key, $data);
    }

    /**
     * Reads data from the adapter
     *
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key): bool
    {
        if (!$this->has($key)) {
            return false;
        }

        $filepath = $this->getFilepath($key);

        return unlink($filepath);
    }

    /**
     * Reads data from the adapter
     *
     * @param string $key
     * @param null   $defaultValue
     *
     * @return mixed
     */
    public function get(string $key, $defaultValue = null)
    {
        $filepath = $this->getFilepath($key);

        if (!file_exists($filepath)) {
            return $defaultValue;
        }

        $payload = $this->getPayload($filepath);

        if (empty($payload)) {
            return $defaultValue;
        }

        if ($this->isExpired($payload)) {
            return $defaultValue;
        }

        $content = Arr::get($payload, "content", null);

        return $this->getUnserializedData($content, $defaultValue);
    }

    /**
     * Always returns null
     *
     * @return null
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Stores data in the adapter
     *
     * @param string $prefix
     *
     * @return array
     */
    public function getKeys(string $prefix = ""): array
    {
        $files     = [];
        $directory = $this->getDir();
        $iterator  = $this->getIterator($directory);

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $key = str_replace($directory, "", $file->getPathName());
                $key = strrchr($key, "/");
                $key = $this->prefix . str_replace("/", "", $key);
                $files[] = $key;
            }
        }

        return $this->getFilteredKeys($files, $prefix);
    }

    /**
     * Checks if an element exists in the cache and is not expired
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        $filepath = $this->getFilepath($key);

        if (!file_exists($filepath)) {
            return false;
        }

        $payload = $this->getPayload($filepath);

        if (empty($payload)) {
            return false;
        }

        return !$this->isExpired($payload);
    }

    /**
     * Increments a stored number
     *
     * @param string $key
     * @param int    $value
     *
     * @return bool|int
     * @throws \Exception
     */
    public function increment(string $key, int $value = 1)
    {
        if (!$this->has($key)) {
            return false;
        }

        $data = $this->get($key);
        $data = (int) $data + $value;

        return $this->set($key, $data);
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
     */
    public function set(string $key, $value, $ttl = null): bool
    {
        $payload   = [
            "created" => time(),
            "ttl"     => $this->getTtl($ttl),
            "content" => $this->getSerializedData($value),
        ];
        $payload   = serialize($payload);
        $directory = $this->getDir($key);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        return false !== file_put_contents($directory . $key, $payload);
    }

    /**
     * Returns the folder based on the storageDir and the prefix
     *
     * @param string $key
     *
     * @return string
     */
    private function getDir(string $key = ""): string
    {
        $dirPrefix   = Str::dirSeparator($this->storageDir . $this->prefix);
        $dirFromFile = Str::dirFromFile(
            str_replace($this->prefix, "", $key)
        );

        return Str::dirSeparator($dirPrefix . $dirFromFile);
    }

    /**
     * Returns the full path to the file
     *
     * @param string $key
     *
     * @return string
     */
    private function getFilepath(string $key): string
    {
        return $this->getDir($key) . str_replace($this->prefix, "", $key);
    }

    /**
     * Returns an iterator for the directory contents
     *
     * @param string $dir
     *
     * @return Iterator
     */
    private function getIterator(string $dir): Iterator
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $dir,
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );
    }

    /**
     * Gets the file contents and returns an array or an error if something
     * went wrong
     *
     * @param string $filepath
     *
     * @return array
     */
    private function getPayload(string $filepath): array
    {
        $payload = file_get_contents($filepath);

        if (false === $payload) {
            return [];
        }

        $this->warning = false;
        set_error_handler(
            function ($number, $message, $file, $line, $context) {
                $this->warning = true;
            },
            E_NOTICE
        );

        $payload = unserialize($payload);

        restore_error_handler();

        if ($this->warning || !is_array($payload)) {
            return [];
        }

        return $payload;
    }

    /**
     * Returns if the cache has expired for this item or not
     *
     * @param array $payload
     *
     * @return bool
     */
    private function isExpired(array $payload): bool
    {
        $created = Arr::get($payload, "created", time());
        $ttl     = Arr::get($payload, "ttl", 3600);

        return ($created + $ttl) < time();
    }
}
