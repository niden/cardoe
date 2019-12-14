<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Config\Adapter;

use Phalcon\Config;
use Phalcon\Config\Exception;

class Yaml extends Config
{
    /**
     * Yaml constructor.
     *
     * @param string     $filePath
     * @param array|null $callbacks
     *
     * @throws Exception
     */
    public function __construct(string $filePath, array $callbacks = null)
    {
        $ndocs = 0;

        if (true !== extension_loaded("yaml")) {
            throw new Exception(
                "Yaml extension not loaded"
            );
        }

        if (empty($callbacks)) {
            $yamlConfig = yaml_parse_file($filePath);
        } else {
            $yamlConfig = yaml_parse_file(
                $filePath,
                0,
                $ndocs,
                $callbacks
            );
        }

        if (false === $yamlConfig) {
            throw new Exception(
                "Configuration file " .
                basename($filePath) .
                " cannot be loaded"
            );
        }

        parent::__construct($yamlConfig);
    }
}
