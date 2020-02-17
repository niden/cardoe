<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Config;

use Phalcon\Config;
use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception as FactoryException;
use Phalcon\Helper\Arr;

use function is_array;
use function is_object;
use function is_string;
use function lcfirst;
use function pathinfo;
use function strpos;
use function strtolower;

use const PATHINFO_EXTENSION;

class ConfigFactory extends AbstractFactory
{
    /**
     * ConfigFactory constructor.
     *
     * @param array $services
     */
    public function __construct(array $services = [])
    {
        $this->init($services);
    }

    /**
     * Load a config to create a new instance
     *
     * @param string|array|Config $config          = [
     *                                             'adapter' => 'ini',
     *                                             'filePath' => 'config.ini',
     *                                             'mode' => null,
     *                                             'callbacks' => null
     *                                             ]
     *
     * @return object
     * @throws Exception
     * @throws FactoryException
     */
    public function load($config): object
    {
        if (is_string($config)) {
            $oldConfig = $config;
            $extension = pathinfo($config, PATHINFO_EXTENSION);

            $this->checkOptionsExtension($extension);

            $config = [
                "adapter"  => $extension,
                "filePath" => $oldConfig,
            ];
        }

        if (is_object($config) && $config instanceof Config) {
            $config = $config->toArray();
        }

        $this
            ->checkOptionsIsArray($config)
            ->checkOptionsFilePath($config)
            ->checkOptionsAdapter($config)
        ;

        $adapter = strtolower($config["adapter"]);
        $first   = $config["filePath"];

        if (!strpos($first, ".")) {
            $first = $first . "." . lcfirst($adapter);
        }

        $second = $this->checkSecond($config, $adapter);

        return $this->newInstance($adapter, $first, $second);
    }

    /**
     * Returns a new Config instance
     *
     * @param string     $name
     * @param string     $fileName
     * @param null|array $params
     *
     * @return object
     * @throws FactoryException
     */
    public function newInstance(
        string $name,
        string $fileName,
        $params = null
    ): object {
        $this->checkService($name);

        $definition = $this->mapper[$name];
        $options    = [];
        $options[]  = $fileName;

        if ("json" !== $name && "php" !== $name) {
            $options[] = $params;
        }

        return new $definition(...$options);
    }

    /**
     * Returns the adapters for the factory
     */
    protected function getAdapters(): array
    {
        return [
            "grouped" => "Phalcon\\Config\\Adapter\\Grouped",
            "ini"     => "Phalcon\\Config\\Adapter\\Ini",
            "json"    => "Phalcon\\Config\\Adapter\\Json",
            "php"     => "Phalcon\\Config\\Adapter\\Php",
            "yaml"    => "Phalcon\\Config\\Adapter\\Yaml",
        ];
    }

    /**
     * @param mixed $extension
     *
     * @throws Exception
     */
    private function checkOptionsExtension($extension): void
    {
        if (empty($extension)) {
            throw new Exception(
                "You need to provide the extension in the file path"
            );
        }
    }

    /**
     * @param mixed $config
     *
     * @return ConfigFactory
     * @throws Exception
     */
    private function checkOptionsIsArray($config): ConfigFactory
    {
        if (!is_array($config)) {
            throw new Exception(
                "Config must be array or Phalcon\\Config object"
            );
        }

        return $this;
    }

    /**
     * @param array $config
     *
     * @return ConfigFactory
     * @throws Exception
     */
    private function checkOptionsFilePath(array $config): ConfigFactory
    {
        if (!isset($config["filePath"])) {
            throw new Exception(
                "You must provide 'filePath' option in factory config parameter."
            );
        }

        return $this;
    }

    /**
     * @param array $config
     *
     * @return ConfigFactory
     * @throws Exception
     */
    private function checkOptionsAdapter(array $config): ConfigFactory
    {
        if (!isset($config["adapter"])) {
            throw new Exception(
                "You must provide 'adapter' option in factory config parameter."
            );
        }

        return $this;
    }

    /**
     * @param array  $config
     * @param string $adapter
     *
     * @return mixed|null
     */
    private function checkSecond(array $config, string $adapter)
    {
        $second = null;

        if ("ini" === $adapter) {
            $second = Arr::get($config, "mode", 1);
        } elseif ("yaml" === $adapter) {
            $second = Arr::get($config, "callbacks", []);
        }

        return $second;
    }
}
