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

class Grouped extends Config
{
    /**
     * Grouped constructor.
     *
     * @param array  $arrayConfig
     * @param string $defaultAdapter
     *
     * @throws Exception
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

            if ("array" === $configInstance["adapter"]) {
                if (true !== isset($configInstance["config"])) {
                    throw new Exception(
                        "To use the 'array' adapter you have to specify " .
                        "the 'config' as an array."
                    );
                }

                $configArray    = $configInstance["config"];
                $configInstance = new Config($configArray);
            } else {
                $configInstance = (new ConfigFactory())->load($configInstance);
            }

            $this->merge($configInstance);
        }
    }
}
