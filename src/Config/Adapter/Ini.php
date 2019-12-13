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
use Cardoe\Config\Exception;

use function basename;
use function call_user_func_array;
use function is_array;
use function is_numeric;
use function is_string;
use function parse_ini_file;
use function preg_match;
use function strpos;
use function strtolower;
use function substr;

use const INI_SCANNER_RAW;

class Ini extends Config
{
    /**
     * Ini constructor.
     *
     * @param string   $filePath
     * @param null|int $mode
     *
     * @throws Exception
     */
    public function __construct(string $filePath, int $mode = null)
    {

        // Default to INI_SCANNER_RAW if not specified
        if (null === $mode) {
            $mode = INI_SCANNER_RAW;
        }

        $iniConfig = parse_ini_file(
            $filePath,
            true,
            $mode
        );

        if (false === $iniConfig) {
            throw new Exception(
                "Configuration file " .
                basename($filePath) .
                " cannot be loaded"
            );
        }

        $config = [];
        foreach ($iniConfig as $section => $directives) {
            if (is_array($directives)) {
                $sections = [];
                foreach ($directives as $path => $lastValue) {
                    $sections[] = $this->parseIniString(
                        (string) $path,
                        $lastValue
                    );
                }

                if (count($sections) > 0) {
                    $config[$section] = call_user_func_array(
                        "array_replace_recursive",
                        $sections
                    );
                }
            } else {
                $config[$section] = $this->cast($directives);
            }
        }

        parent::__construct($config);
    }

    /**
     * We have to cast values manually because parse_ini_file() has a poor
     * implementation.
     *
     * @param array | string $ini
     *
     * @return bool|float|int|null
     */
    protected function cast($ini)
    {
        if (is_array($ini)) {
            foreach ($ini as $key => $value) {
                $ini[$key] = $this->cast($value);
            }

            return $ini;
        }

        // Decode true
        $ini      = (string) $ini;
        $lowerIni = strtolower($ini);

        switch ($lowerIni) {
            case "true":
            case "yes":
            case "on":
                return true;
            case "false":
            case "no":
            case "off":
                return false;
            case "null":
                return null;
        }

        // Decode float/int
        if (is_string($ini) && is_numeric($ini)) {
            if (true === preg_match("/[.]+/", $ini)) {
                return (double) $ini;
            } else {
                return (int) $ini;
            }
        }

        return $ini;
    }

    /**
     * Build multidimensional array from string
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return array
     */
    protected function parseIniString(string $path, $value): array
    {
        $value    = $this->cast($value);
        $position = strpos($path, ".");

        if (false === $position) {
            return [
                $path => $value,
            ];
        }

        $key  = substr($path, 0, $position);
        $path = substr($path, $position + 1);

        return [
            $key => $this->parseIniString($path, $value),
        ];
    }
}
