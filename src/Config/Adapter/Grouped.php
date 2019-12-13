<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Config\Adapter;

use Cardoe\Config\Config;
use Cardoe\Config\ConfigFactory;
use Cardoe\Config\Exception;
use Cardoe\Factory\Exception as ExceptionAlias;

class Grouped extends Config
{
    /**
     * Grouped constructor.
     *
     * @param array  $arrayConfig
     * @param string $defaultAdapter
     *
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function __construct(array $arrayConfig, string $defaultAdapter = "php")
    {
        parent::__construct([]);

        foreach ($arrayConfig as $configName) {
            $configInstance = $configName;

            // Set to default adapter if passed as string
            if (is_string($configName)) {
                if ("" === $defaultAdapter) {
                    $this->merge(
                        (new ConfigFactory())->load($configName)
                    );

                    continue;
                }

                $configInstance = [
                    "filePath" => $configName,
                    "adapter"  => $defaultAdapter,
                ];
            } elseif (true !== isset($configInstance["adapter"])) {
                $configInstance["adapter"] = $defaultAdapter;
            }

            $configInstance = $this->getInstance($configInstance);

            $this->merge($configInstance);
        }
    }

    /**
     * @param array $configInstance
     *
     * @throws Exception
     */
    private function checkArrayAdapter(array $configInstance)
    {
        if (true !== isset($configInstance["config"])) {
            throw new Exception(
                "To use the 'array' adapter you have to specify " .
                "the 'config' as an array."
            );
        }
    }

    /**
     * @param array $configInstance
     *
     * @return mixed
     * @throws Exception
     * @throws ExceptionAlias
     */
    private function getInstance(array $configInstance)
    {
        if ("array" === $configInstance["adapter"]) {
            $this->checkArrayAdapter($configInstance);

            $configArray    = $configInstance["config"];
            return new Config($configArray);
        } else {
            return (new ConfigFactory())->load($configInstance);
        }
    }
}
