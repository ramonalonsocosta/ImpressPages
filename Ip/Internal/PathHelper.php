<?php
/**
 * @package   ImpressPages
 */

namespace Ip\Internal;


class PathHelper
{
    /**
     * @ignore
     * @param int $callLevel
     * @return string
     * @throws \Ip\Exception
     */
    public static function ipRelativeDir($callLevel = 0)
    {
        if (PHP_VERSION_ID >= 50400) { // PHP 5.4 supports debug backtrace level
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $callLevel + 1);
        } else {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        }

        if (!isset($backtrace[$callLevel]['file'])) {
            throw new \Ip\Exception("Can't find caller");
        }

        $absoluteFile = $backtrace[$callLevel]['file'];

        if (DIRECTORY_SEPARATOR == '\\') {
            // Replace windows paths
            $absoluteFile = str_replace('\\', '/', $absoluteFile);
        }

        $overrides = ipConfig()->getRaw('fileOverrides');
        if ($overrides) {
            foreach ($overrides as $relativePath => $fullPath) {
                if (DIRECTORY_SEPARATOR == '\\') {
                    // Replace windows paths
                    $fullPath = str_replace('\\', '/', $fullPath);
                }
                if (strpos($absoluteFile, $fullPath) === 0) {
                    $relativeFile = substr_replace($absoluteFile, $relativePath, 0, strlen($fullPath));
                    return substr($relativeFile, 0, strrpos($relativeFile, '/') + 1);
                }
            }
        }

        $baseDir = ipConfig()->getRaw('baseDir');

        $baseDir = str_replace('\\', '/', $baseDir);
        if (strpos($absoluteFile, $baseDir) !== 0) {
            throw new \Ip\Exception('Cannot find relative path for file ' . $absoluteFile);
        }

        $relativeFile = substr($absoluteFile, strlen($baseDir) + 1);

        return substr($relativeFile, 0, strrpos($relativeFile, '/') + 1);
    }

}
