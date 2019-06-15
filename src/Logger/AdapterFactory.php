<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Logger;

use Cardoe\Factory\AbstractFactory;
use Cardoe\Factory\Exception;
use Cardoe\Logger\Adapter\AdapterInterface;
use Cardoe\Logger\Adapter\Noop;
use Cardoe\Logger\Adapter\Stream;
use Cardoe\Logger\Adapter\Syslog;

/**
 * Class AdapterFactory
 *
 * @package Cardoe\Logger
 */
class AdapterFactory extends AbstractFactory
{
    /**
     * AdapterFactory constructor.
     *
     * @param array $services
     */
    public function __construct(array $services = [])
    {
        $this->init($services);
    }

    /**
     * Create a new instance of the adapter
     *
     * @param string $name
     * @param string $fileName
     * @param array  $options
     *
     * @return AdapterInterface
     * @throws Exception
     */
    public function newInstance(
        string $name,
        string $fileName,
        array $options = []
    ): AdapterInterface {
        $this->checkService($name);

        if (true !== isset($this->service[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition($fileName, $options);
        }

        return $this->services[$name];
    }

    /**
     * @return array
     */
    protected function getAdapters(): array
    {
        return [
            "noop"   => Noop::class,
            "stream" => Stream::class,
            "syslog" => Syslog::class,
        ];
    }
}
