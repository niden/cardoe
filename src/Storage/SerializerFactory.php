<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Storage;

use Cardoe\Factory\AbstractFactory;
use Cardoe\Factory\Exception;
use Cardoe\Storage\Serializer\Base64;
use Cardoe\Storage\Serializer\Igbinary;
use Cardoe\Storage\Serializer\Json;
use Cardoe\Storage\Serializer\Msgpack;
use Cardoe\Storage\Serializer\None;
use Cardoe\Storage\Serializer\Php;
use Cardoe\Storage\Serializer\SerializerInterface;

/**
 * Class SerializerFactory
 *
 * @package Cardoe\Storage
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
