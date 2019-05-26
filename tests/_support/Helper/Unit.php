<?php

namespace Helper;

use Codeception\Module;
use PHPUnit\Framework\SkippedTestError;
use function file_exists;
use function is_file;
use function uniqid;
use function unlink;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends Module
{
    /**
     * Checks if an extension is loaded and if not, skips the test
     *
     * @param string $extension The extension to check
     */
    public function checkExtensionIsLoaded(string $extension)
    {
        if (true !== extension_loaded($extension)) {
            $this->skipTest(
                sprintf("Extension '%s' is not loaded. Skipping test", $extension)
            );
        }
    }

    /**
     * Throws the SkippedTestError exception to skip a test
     *
     * @param string $message The message to display
     */
    public function skipTest(string $message)
    {
        throw new SkippedTestError($message);
    }

    /**
     * Returns a unique file name
     *
     * @param string $prefix A prefix for the file
     * @param string $suffix A suffix for the file
     *
     * @return string
     */
    public function getNewFileName(string $prefix = '', string $suffix = 'log')
    {
        $prefix = ($prefix) ? $prefix . '_' : '';
        $suffix = ($suffix) ? $suffix : 'log';

        return uniqid($prefix, true) . '.' . $suffix;
    }

    /**
     * @param string $filename
     */
    public function safeDeleteFile(string $filename)
    {
        if (true === file_exists($filename) && true === is_file($filename)) {
            unlink($filename);
        }
    }
}
