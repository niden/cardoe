<?php

error_reporting(-1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
setlocale(LC_ALL, 'en_US.utf-8');

date_default_timezone_set('UTC');
mb_internal_encoding('utf-8');
mb_substitute_character('none');

clearstatcache();

$root = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
define('APP_PATH', $root);

unset($root);

$folders = [
    'logs',
];
foreach ($folders as $folder) {
    $item = outputDir('tests/' . $folder);
    if (true !== file_exists($item)) {
        mkdir($item, 0777, true);
    }
}

function dataDir(string $fileName = ''): string
{
    return codecept_data_dir() . $fileName;
}

function fixturesDir(string $fileName = '')
{
    return codecept_data_dir('fixtures') . $fileName;
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
