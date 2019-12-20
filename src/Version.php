<?php

namespace kbATeam\AppVersion;

use kbATeam\Version\FileVersion;
use kbATeam\Version\GitVersion;

/**
 * Class kbATeam\AppVersion\Version
 *
 * Get the current application version.
 * Usage: echo Version::string();
 *
 * @package kbATeam\AppVersion
 * @author  Gregor J.
 * @license MIT
 */
class Version
{
    /**
     * Get the current application version either from the given file, a default file
     * location or from the current GIT repository.
     * @param string|null $file
     * @return string
     */
    public static function string($file = null)
    {
        if ($file === null) {
            $file = APP.DS.'webroot'.DS.'commit.json';
        }
        static $version;
        static $versionFile;
        if ($version === null || $file !== $versionFile) {
            $version = new FileVersion($file);
            if ($version->exists()) {
                $versionFile = $file;
            } else {
                $version = new GitVersion(APP);
            }
        }
        if ($version->exists()) {
            return sprintf(
                '%s (rev. %s)',
                $version->getBranch(),
                $version->getCommit()
            );
        }
        return '~ ? ~';
    }
}
