<?php

declare(strict_types=1);

use Dotenv\Dotenv;

error_reporting(-1);

ini_set('display_errors', "On");
ini_set('display_startup_errors', "On");
setlocale(LC_ALL, 'en_US.utf-8');

date_default_timezone_set('UTC');
mb_internal_encoding('utf-8');
mb_substitute_character('none');

clearstatcache();

$root = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
define('APP_PATH', $root);
define('APP_DATA', dataDir());

unset($root);

function dataDir(string $fileName = ''): string
{
    return codecept_data_dir() . $fileName;
}


function logsDir(string $fileName = ''): string
{
    return codecept_output_dir() . 'tests/logs/' . $fileName;
}

/**
 * @param string $fileName
 *
 * @return string
 */
function outputDir(string $fileName = '')
{
    return codecept_output_dir() . $fileName;
}


function env(string $key, $default = null)
{
    if (defined($key)) {
        return constant($key);
    }

    return getenv($key) ?: $default;
}

/*******************************************************************************
 * Options
 *******************************************************************************/
function getOptionsLibmemcached(): array
{
    return [
        'client'  => [],
        'servers' => [
            [
                'host'   => env('TEST_MEMCACHED_HOST', '127.0.0.1'),
                'port'   => env('TEST_MEMCACHED_PORT', 11211),
                'weight' => env('TEST_MEMCACHED_WEIGHT', 0),
            ],
        ],
    ];
}

function getOptionsRedis(): array
{
    return [
        'host'  => env('TEST_REDIS_HOST'),
        'port'  => env('TEST_REDIS_PORT'),
        'index' => env('TEST_REDIS_NAME'),
    ];
}

$folders = [
    'logs',
    'stream',
];

foreach ($folders as $folder) {
    $item = outputDir('tests/' . $folder);
    if (true !== file_exists($item)) {
        mkdir($item, 0777, true);
    }
}

/**
 * Set up environment variables for the testing suite
 *
 * Differentiate between GitHub actions and nanobox
 */
$environment = getenv('GITHUB_WORKFLOW');
$environment = (!$environment) ? 'local' : 'github';

Dotenv::createImmutable(
    codecept_root_dir('config/'),
    '.env.' . $environment
)->load();
