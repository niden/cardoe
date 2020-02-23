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

namespace Phalcon;

use Phalcon\Filter\Exception;
use Phalcon\Filter\FilterInterface;

use function array_merge;
use function call_user_func_array;
use function is_array;
use function is_string;
use function trigger_error;

use const E_USER_NOTICE;

/**
 * Lazy loads, stores and exposes sanitizer objects
 *
 * @property array $mapper
 * @property array $services
 */
class Filter implements FilterInterface
{
    public const FILTER_ABSINT      = "absint";
    public const FILTER_ALNUM       = "alnum";
    public const FILTER_ALPHA       = "alpha";
    public const FILTER_BOOL        = "bool";
    public const FILTER_EMAIL       = "email";
    public const FILTER_FLOAT       = "float";
    public const FILTER_INT         = "int";
    public const FILTER_LOWER       = "lower";
    public const FILTER_LOWERFIRST  = "lowerFirst";
    public const FILTER_REGEX       = "regex";
    public const FILTER_REMOVE      = "remove";
    public const FILTER_REPLACE     = "replace";
    public const FILTER_SPECIAL     = "special";
    public const FILTER_SPECIALFULL = "specialFull";
    public const FILTER_STRING      = "string";
    public const FILTER_STRIPTAGS   = "striptags";
    public const FILTER_TRIM        = "trim";
    public const FILTER_UPPER       = "upper";
    public const FILTER_UPPERFIRST  = "upperFirst";
    public const FILTER_UPPERWORDS  = "upperWords";
    public const FILTER_URL         = "url";

    /**
     * @var array
     */
    protected $mapper = [];

    /**
     * @var array
     */
    protected $services = [];

    /**
     * Key value pairs with name as the key and a callable as the value for
     * the service object
     *
     * @param array $mapper
     */
    public function __construct(array $mapper = [])
    {
        $this->init($mapper);
    }

    /**
     * Get a service. If it is not in the mapper array, create a new object,
     * set it and then return it.
     *
     * @param string $name
     *
     * @return object
     * @throws Exception
     */
    public function get(string $name): object
    {
        if (!isset($this->mapper[$name])) {
            throw new Exception(
                "The service " . $name
                . " has not been found in the locator"
            );
        }

        if (!isset($this->services[$name])) {
            $definition = $this->mapper[$name];
            if (is_string($definition)) {
                $this->services[$name] = new $definition();
            } else {
                $this->services[$name] = $definition;
            }
        }

        return $this->services[$name];
    }

    /**
     * Checks if a service exists in the map array
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->mapper[$name]);
    }

    /**
     * Sanitizes a value with a specified single or set of sanitizers
     *
     * @param mixed        $value
     * @param array|string $sanitizers
     * @param bool         $noRecursive
     *
     * @return mixed
     * @throws Exception
     */
    public function sanitize($value, $sanitizers, bool $noRecursive = false)
    {
        /**
         * First we need to figure out whether this is one sanitizer (string) or
         * an array with different sanitizers in it.
         *
         * All is well if the sanitizer accepts only one parameter, but certain
         * sanitizers require more than one parameter. To figure this out we
         * need to of course call call_user_func_array() but with the correct
         * parameters.
         *
         * If the array is passed with just values then those are just the
         * sanitizer names i.e.
         *
         * $locator->sanitize( 'abcde', ['trim', 'upper'])
         *
         * If the sanitizer requires more than one parameter then we need to
         * inject those parameters in the sanitize also:
         *
         * $locator->sanitize(
         *         '  mary had a little lamb ',
         *         [
         *             'trim',
         *             'replace' => [' ', '-'],
         *             'remove'  => ['mary'],
         *         ]
         * );
         *
         * The above should produce "-had-a-little-lamb"
         */

        /**
         * Filter is an array
         */
        if (is_array($sanitizers)) {
            /**
             * Null value - return immediately
             */
            if (null === $value) {
                return null;
            }

            return $this->processArraySanitizers(
                $sanitizers,
                $value,
                $noRecursive
            );
        }

        /**
         * Apply a single sanitizer to the values. Check if the values are an
         * array
         */
        if (is_array($value) && !$noRecursive) {
            return $this->processArrayValues($value, $sanitizers);
        }

        /**
         * One value one sanitizer
         */
        return $this->sanitizer($value, $sanitizers);
    }

    /**
     * Set a new service to the mapper array
     *
     * @param string          $name
     * @param callable|string $service
     */
    public function set(string $name, $service): void
    {
        $this->mapper[$name] = $service;

        unset($this->services[$name]);
    }

    /**
     * Loads the objects in the internal mapper array
     *
     * @param array $mapper
     */
    protected function init(array $mapper): void
    {
        foreach ($mapper as $name => $service) {
            $this->set($name, $service);
        }
    }

    /**
     * Processes the array values with the relevant sanitizers
     *
     * @param array  $values
     * @param string $sanitizerName
     * @param array  $sanitizerParams
     *
     * @return array
     * @throws Exception
     */
    private function processArrayValues(
        array $values,
        string $sanitizerName,
        array $sanitizerParams = []
    ): array {
        $arrayValue = [];

        foreach ($values as $itemKey => $itemValue) {
            $arrayValue[$itemKey] = $this->sanitizer(
                $itemValue,
                $sanitizerName,
                $sanitizerParams
            );
        }

        return $arrayValue;
    }

    /**
     * @param array $sanitizers
     * @param mixed $value
     * @param bool  $noRecursive
     *
     * @return string|array
     * @throws Exception
     */
    private function processArraySanitizers(
        array $sanitizers,
        $value,
        bool $noRecursive = false
    ) {
        /**
         * `value` is something. Loop through the sanitizers
         */
        foreach ($sanitizers as $sanitizerKey => $sanitizer) {
            /**
             * If `sanitizer` is an array, that means that the sanitizerKey
             * is the name of the sanitizer.
             */
            if (is_array($sanitizer)) {
                $sanitizerName   = $sanitizerKey;
                $sanitizerParams = $sanitizer;
            } else {
                $sanitizerName   = $sanitizer;
                $sanitizerParams = [];
            }

            /**
             * Check if the value is an array of elements. If `noRecursive`
             * has been defined it is a straight up; otherwise recursion is
             * required
             */
            if (is_array($value) && !$noRecursive) {
                $value = $this->processArrayValues(
                    $value,
                    $sanitizerName,
                    $sanitizerParams
                );
            } else {
                $value = $this->sanitizer(
                    $value,
                    $sanitizerName,
                    $sanitizerParams
                );
            }
        }

        return $value;
    }

    /**
     * Internal sanitize wrapper for recursion
     *
     * @param mixed  $value
     * @param string $sanitizerName
     * @param array  $sanitizerParams
     *
     * @return mixed
     * @throws Exception
     */
    private function sanitizer(
        $value,
        string $sanitizerName,
        array $sanitizerParams = []
    ) {
        if (!$this->has($sanitizerName)) {
            if (!empty($sanitizerName)) {
                trigger_error(
                    "Sanitizer '" . $sanitizerName . "' is not registered",
                    E_USER_NOTICE
                );
            }

            return $value;
        }

        $sanitizerObject = $this->get($sanitizerName);
        $params          = array_merge([$value], $sanitizerParams);

        return call_user_func_array($sanitizerObject, $params);
    }
}
