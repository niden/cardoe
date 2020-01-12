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

define('APP_DATA', dataDir());
define('APP_PATH', codecept_root_dir());
define('APP_PATH_OUTPUT', outputDir());

/**
 * Tests data directory
 *
 * @param string $fileName
 *
 * @return string
 */
function dataDir(string $fileName = ''): string
{
    return codecept_data_dir() . $fileName;
}


/**
 * Tests output log directory
 *
 * @param string $fileName
 *
 * @return string
 */
function logsDir(string $fileName = ''): string
{
    return codecept_output_dir() . 'tests/logs/' . $fileName;
}

/**
 * Tests output directory
 *
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
/**
 * Return the Memcached options
 *
 * @return array
 */
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

/**
 * Return the Redis options
 *
 * @return array
 */
function getOptionsRedis(): array
{
    return [
        'host'  => env('TEST_REDIS_HOST'),
        'port'  => env('TEST_REDIS_PORT'),
        'index' => env('TEST_REDIS_NAME'),
    ];
}

/**
 * Create directories if they are not there
 */
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
