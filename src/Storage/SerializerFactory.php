<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Storage;

use Phalcon\Factory\AbstractFactory;
use Phalcon\Factory\Exception;
use Phalcon\Storage\Serializer\Base64;
use Phalcon\Storage\Serializer\Igbinary;
use Phalcon\Storage\Serializer\Json;
use Phalcon\Storage\Serializer\Msgpack;
use Phalcon\Storage\Serializer\None;
use Phalcon\Storage\Serializer\Php;
use Phalcon\Storage\Serializer\SerializerInterface;

/**
 * Class SerializerFactory
 *
 * @package Phalcon\Storage
 */
class SerializerFactory extends AbstractFactory
{
    /**
     * SerializerFactory constructor.
     *
     * @param array $services
     */
    public function __construct(array $services = [])
    {
        $this->init($services);
    }

    /**
     * @param string $name
     *
     * @return SerializerInterface
     * @throws Exception
     */
    public function newInstance(string $name): SerializerInterface
    {
        $this->checkService($name);

        if (!isset($this->services[$name])) {
            $definition            = $this->mapper[$name];
            $this->services[$name] = new $definition();
        }

        return $this->services[$name];
    }

    /**
     * @return array
     */
    protected function getAdapters(): array
    {
        return [
            "base64"   => Base64::class,
            "igbinary" => Igbinary::class,
            "json"     => Json::class,
            "msgpack"  => Msgpack::class,
            "none"     => None::class,
            "php"      => Php::class,
        ];
    }
}
