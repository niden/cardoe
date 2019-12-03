<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

$template = '<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Test\%type%\%n%;

use %type%Tester;

class %m%Cest
{
    /**
     * %type% Tests %ns% :: %sm%()
     *
     * @since  %d%
     */
    public function %nn%%m%(%type%Tester $I)
    {
        $I->wantToTest(\'%n% - %sm%()\');

        $I->skipTest(\'Need implementation\');
    }
}
';

/**
 * Require all the classes we need
 */

$baseDir   = dirname(__DIR__);
$sourceDir = $baseDir . '/src/';
$outputDir = $baseDir . '/nikos/';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

$files = [
    "Autoload/Exception.php",
    "Autoload/Loader.php",
    "Factory/AbstractFactory.php",
    "Factory/Exception.php",
    "Storage/Adapter/AdapterInterface.php",
    "Storage/Adapter/AbstractAdapter.php",
    "Storage/Adapter/Apcu.php",
    "Storage/Adapter/Libmemcached.php",
    "Storage/Adapter/Memory.php",
    "Storage/Adapter/Redis.php",
    "Storage/Adapter/Stream.php",
    "Storage/AdapterFactory.php",
    "Storage/Exception.php",
    "Storage/Serializer/SerializerInterface.php",
    "Storage/Serializer/AbstractSerializer.php",
    "Storage/Serializer/Base64.php",
    "Storage/Serializer/Igbinary.php",
    "Storage/Serializer/Json.php",
    "Storage/Serializer/Msgpack.php",
    "Storage/Serializer/None.php",
    "Storage/Serializer/Php.php",
    "Storage/SerializerFactory.php",
    "Cache/Adapter/AdapterInterface.php",
    "Cache/Adapter/Apcu.php",
    "Cache/Adapter/Libmemcached.php",
    "Cache/Adapter/Memory.php",
    "Cache/Adapter/Redis.php",
    "Cache/Adapter/Stream.php",
    "Cache/AdapterFactory.php",
    "Cache/Cache.php",
    "Cache/CacheFactory.php",
    "Cache/Exception/Exception.php",
    "Cache/Exception/InvalidArgumentException.php",
    "Collection/Collection.php",
    "Collection/Exception.php",
    "Collection/ReadCollection.php",
    "Domain/Payload/ReadableInterface.php",
    "Domain/Payload/WriteableInterface.php",
    "Domain/Payload/PayloadInterface.php",
    "Domain/Payload/Payload.php",
    "Domain/Payload/PayloadFactory.php",
    "Domain/Payload/Status.php",
    "Helper/Arr.php",
    "Helper/Exception.php",
    "Helper/Number.php",
    "Helper/Obj.php",
    "Helper/Str.php",
    "Http/Client/AbstractCommon.php",
    "Http/Client/Client.php",
    "Http/Client/ClientFactory.php",
    "Http/Client/Exception/RequestException.php",
    "Http/Client/Exception/NetworkException.php",
    "Http/Client/Middleware/MiddlewareInterface.php",
    "Http/Client/Middleware/Closure.php",
    "Http/Client/Middleware/Cookie/Storage.php",
    "Http/Client/Middleware/Cookie/FileStorage.php",
    "Http/Client/Middleware/Cookie/CookieRequest.php",
    "Http/Client/Middleware/Cookie/CookieResponse.php",
    "Http/Client/Middleware/Deflate.php",
    "Http/Client/Middleware/Fallback.php",
    "Http/Client/Middleware/UserAgent.php",
    "Http/Client/Request/HandlerInterface.php",
    "Http/Client/Request/Handler.php",
    "Http/Client/Transport/TransportInterface.php",
    "Http/Client/Transport/AbstractTransport.php",
    "Http/Client/Transport/Curl.php",
    "Http/Client/Transport/Stream.php",
    "Http/Cookies/SetCookie.php",
    "Http/Message/Traits/CommonTrait.php",
    "Http/Message/Traits/MessageTrait.php",
    "Http/Message/Traits/RequestTrait.php",
    "Http/Message/Traits/ResponseTrait.php",
    "Http/Message/Traits/ServerRequestFactoryTrait.php",
    "Http/Message/Traits/StreamTrait.php",
    "Http/Message/Traits/UriTrait.php",
    "Http/Message/Exception/InvalidArgumentException.php",
    "Http/Message/Request.php",
    "Http/Message/RequestFactory.php",
    "Http/Message/Response.php",
    "Http/Message/ResponseFactory.php",
    "Http/Message/ServerRequest.php",
    "Http/Message/ServerRequestFactory.php",
    "Http/Message/Stream.php",
    "Http/Message/Stream/Input.php",
    "Http/Message/Stream/Memory.php",
    "Http/Message/Stream/Temp.php",
    "Http/Message/StreamFactory.php",
    "Http/Message/UploadedFile.php",
    "Http/Message/UploadedFileFactory.php",
    "Http/Message/Uri.php",
    "Http/Message/UriFactory.php",
    "Link/Link.php",
    "Link/LinkProvider.php",
    "Link/EvolvableLink.php",
    "Link/EvolvableLinkProvider.php",
    "Logger/Adapter/AdapterInterface.php",
    "Logger/Adapter/AbstractAdapter.php",
    "Logger/Adapter/Noop.php",
    "Logger/Adapter/Stream.php",
    "Logger/Adapter/Syslog.php",
    "Logger/AdapterFactory.php",
    "Logger/Exception.php",
    "Logger/Formatter/FormatterInterface.php",
    "Logger/Formatter/AbstractFormatter.php",
    "Logger/Formatter/Json.php",
    "Logger/Formatter/Line.php",
    "Logger/Formatter/Syslog.php",
    "Logger/FormatterFactory.php",
    "Logger/Item.php",
    "Logger/Logger.php",
    "Logger/LoggerFactory.php",
    "Security/Password.php",
];

foreach ($files as $file) {
    include_once $sourceDir . $file;
}

$allClasses     = get_declared_classes();
$cardoeClasses = [];

foreach ($allClasses as $class) {
    if ('Cardoe\\' === substr($class, 0, 7)) {
        $cardoeClasses[] = $class;
    }
}

// Argument 1: could be "unit" or "integration" shortcut "u" or "i"
$type = ucfirst($argv[1] ?? 'unit');

// Normalize shortcut I = Integration or U = Unit
if (strlen($type) === 1) {
    $type = $type === 'I' ? 'Integration' : 'Unit';
}

$placeholders = [
    '%type%' => $type,
    '%ns%'   => '',
    '%nn%'   => '',
    '%n%'    => '',
    '%m%'    => '',
    '%sm%'   => '',
    '%d%'    => date('Y-m-d'),
];

$outputDir = dirname(__DIR__) . '/nikos/';

foreach ($cardoeClasses as $class) {
    $newClass = str_replace('Cardoe\\', '', $class);

    $methods = get_class_methods($class);

    sort($methods);

    foreach ($methods as $method) {
        $placeholders['%ns%'] = $class;
        $placeholders['%n%']  = $newClass;
        $placeholders['%nn%'] = lcfirst(str_replace('\\', '', $newClass));
        $placeholders['%sm%'] = $method;

        switch ($method) {
            case '__construct':
                $method = 'construct';

                break;
            case '__destruct':
                $method = 'destruct';

                break;
            case '__toString':
                $method = 'toString';

                break;
            case '__get':
                $method = 'underscoreGet';

                break;
            case '__set':
                $method = 'underscoreSet';

                break;
            case '__isset':
                $method = 'underscoreIsSet';

                break;
            case '__unset':
                $method = 'underscoreUnset';

                break;
            case '__call':
                $method = 'underscoreCall';

                break;
            case '__invoke':
                $method = 'underscoreInvoke';

                break;
            case '__wakeup':
                $method = 'wakeup';

                break;
        }

        $placeholders['%m%'] = ucfirst($method);

        $dir = str_replace(
            '\\',
            '/',
            $outputDir . $class
        );

        @mkdir($dir, 0777, true);

        $from     = array_keys($placeholders);
        $to       = array_values($placeholders);
        $contents = str_replace($from, $to, $template);

        $fileName = str_replace(
            '\\',
            '/',
            $outputDir . $class . '/' . ucfirst($method) . 'Cest.php'
        );

        echo 'Filename: ' . $fileName . PHP_EOL;

        file_put_contents($fileName, $contents);
    }
}
