<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Logger;

use Cardoe\Factory\AbstractFactory;
use Cardoe\Factory\Exception as FactoryException;
use Cardoe\Logger\Formatter\FormatterInterface;
use Cardoe\Logger\Formatter\Json;
use Cardoe\Logger\Formatter\Line;
use Cardoe\Logger\Formatter\Syslog;

/**
 * Class AdapterFactory
 *
 * @package Cardoe\Logger
 */
class FormatterFactory extends AbstractFactory
{
    /**
     * FormatterFactory constructor.
     *
     * @param array $services
     */
    public function __construct(array $services = [])
    {
        $this->init($services);
    }

    /**
     * Create a new instance of the formatter
     *
     * @param string $name
     * @param array  $options
     *
     * @return FormatterInterface
     * @throws FactoryException
     */
    public function newInstance(
        string $name,
        array $options = []
    ): FormatterInterface {
        $this->checkService($name);

        if (!isset($this->services[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition($name, $options);
        }

        return $this->services[$name];
    }

    /**
     * @return array
     */
    protected function getAdapters(): array
    {
        return [
            "json"   => Json::class,
            "line"   => Line::class,
            "syslog" => Syslog::class,
        ];
    }
}
