<?php

declare(strict_types=1);

use Codeception\Util\Autoload;

$root = dirname(realpath(__DIR__) . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
define('PROJECT_PATH', $root);

require_once $root . 'tests/_ci/functions.php';

loadIni();
loadAutoloader($root);
loadFolders();
loadDefined();

unset($root);
