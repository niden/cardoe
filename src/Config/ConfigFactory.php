<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Config;

use Cardoe\Factory\AbstractFactory;
use Cardoe\Factory\Exception as FactoryException;
use Cardoe\Helper\Arr;

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
     * @param Config|array|string $config
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
            $this->checkExtension($extension);

            $config = [
                "adapter"  => $extension,
                "filePath" => $oldConfig,
            ];
        }

        if (
            is_object($config) &&
            $config instanceof Config
        ) {
            $config = $config->toArray();
        }

        $this
            ->checkConfig($config)
            ->checkFilePath($config)
            ->checkAdapter($config)
        ;

        $adapter = strtolower($config["adapter"]);
        $first   = $config["filePath"];
        $second  = null;

        if (!strpos($first, ".")) {
            $first = $first . "." . lcfirst($adapter);
        }

        if ("ini" === $adapter) {
            $second = Arr::get($config, "mode", 1);
        } elseif ("yaml" === $adapter) {
            $second = Arr::get($config, "callbacks", []);
        }

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
            "grouped" => "Cardoe\\Config\\Adapter\\Grouped",
            "ini"     => "Cardoe\\Config\\Adapter\\Ini",
            "json"    => "Cardoe\\Config\\Adapter\\Json",
            "php"     => "Cardoe\\Config\\Adapter\\Php",
            "yaml"    => "Cardoe\\Config\\Adapter\\Yaml",
        ];
    }

    /**
     * @param array $config
     *
     * @return ConfigFactory
     * @throws Exception
     */
    private function checkAdapter(array $config): ConfigFactory
    {
        if (true !== isset($config["adapter"])) {
            throw new Exception(
                "You must provide 'adapter' option in factory config parameter."
            );
        }

        return $this;
    }

    /**
     * @param $config
     *
     * @return ConfigFactory
     * @throws Exception
     */
    private function checkConfig($config): ConfigFactory
    {
        if (true !== is_array($config)) {
            throw new Exception(
                "Config must be array or Cardoe\\Config\\Config object"
            );
        }

        return $this;
    }

    /**
     * @param string $extension
     *
     * @return ConfigFactory
     * @throws Exception
     */
    private function checkExtension(string $extension): ConfigFactory
    {
        if (true === empty($extension)) {
            throw new Exception(
                "You need to provide the extension in the file path"
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
    private function checkFilePath(array $config): ConfigFactory
    {
        if (true !== isset($config["filePath"])) {
            throw new Exception(
                "You must provide 'filePath' option in factory config parameter."
            );
        }

        return $this;
    }
}
