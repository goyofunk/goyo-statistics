<?php
namespace GOYO_STATISTICS;

/** Legacy uninstall entry points preserve collected statistics and settings. */
class Uninstall
{
    public function __construct()
    {
    }

    public function goyo_statistics_site_removal()
    {
        // Intentional: uninstall never deletes statistics.
    }
}
