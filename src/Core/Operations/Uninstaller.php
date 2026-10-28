<?php
namespace Goyo_Statistics\Core\Operations;

use Goyo_Statistics\Core\AbstractCore;

/** Removing the plugin preserves collected statistics and settings. */
class Uninstaller extends AbstractCore
{
    public function __construct($networkWide = false)
    {
        // Data retention is independent of old delete-on-uninstall settings.
    }

    public function execute()
    {
        // Intentional: uninstall never deletes statistics.
    }

    public function cleanupSiteData()
    {
        // Retain this legacy entry point without destructive behavior.
    }
}
