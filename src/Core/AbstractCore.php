<?php

namespace Goyo_Statistics\Core;

use GOYO_STATISTICS\Option;

/**
 * Base class containing shared initialization logic and utilities for core components.
 *
 * Provides helpers for option setup, required file loading, version checks and updates,
 * and enforces an `execute()` method that concrete subclasses must implement.
 *
 * @package Goyo_Statistics\Core
 */
abstract class AbstractCore
{
    /**
     * Stores the current plugin version retrieved from the database.
     *
     * @var string
     */
    protected $currentVersion;

    /**
     * Stores the latest version of the plugin defined by the codebase.
     *
     * @var string
     */
    protected $latestVersion;

    /**
     * Whether operations are being performed network-wide (multisite network activation).
     *
     * @var bool
     */
    protected $networkWide = false;

    /**
     * WordPress database access object.
     *
     * @var \wpdb
     */
    protected $wpdb;

    /**
     * AbstractCore constructor.
     *
     * @return void
     */
    public function __construct($networkWide = false)
    {
        $this->latestVersion = GOYO_STATISTICS_VERSION;
        $this->networkWide   = (bool)$networkWide;

        $this->setWpdb();
    }

    /**
     * Initialize the wpdb property from the global $wpdb.
     */
    private function setWpdb()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
    }

    /**
     * Initialize default options.
     *
     * @return void
     */
    protected function initializeDefaultOptions()
    {
        $this->loadRequiredFiles();

        $options = get_option(Option::$opt_name);
        // Fill missing defaults without replacing saved preferences or custom keys.
        $options = is_array($options) ? $options : [];
        $complete = array_replace(Option::defaultOption(), $options);
        if ($complete !== $options) {
            update_option(Option::$opt_name, $complete);
        }
    }

    /**
     * Load required files.
     *
     * @return void
     */
    private function loadRequiredFiles()
    {
        require_once GOYO_STATISTICS_DIR . 'includes/admin/class-wp-statistics-admin-template.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-option.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-helper.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-user-online.php';
        require_once GOYO_STATISTICS_DIR . 'includes/class-wp-statistics-visitor.php';
    }

    /**
     * Checks whether the plugin is a fresh installation.
     *
     * @return void
     */
    protected function checkIsFresh()
    {
        $version = get_option('goyo_statistics_plugin_version');

        if (empty($version)) {
            update_option('goyo_statistics_is_fresh', true);
        } else {
            update_option('goyo_statistics_is_fresh', false);
        }

        $installationTime = get_option('goyo_statistics_installation_time');

        if (empty($installationTime)) {
            update_option('goyo_statistics_installation_time', time());
        }
    }

    /**
     * Checks whether the plugin is updated.
     *
     * @return bool
     */
    protected function isUpdated()
    {
        $this->currentVersion = get_option('goyo_statistics_plugin_version', false);

        return $this->currentVersion != $this->latestVersion;
    }

    /**
     * Update the plugin version.
     *
     * @return void
     */
    protected function updateVersion()
    {
        update_option('goyo_statistics_plugin_version', $this->latestVersion);
    }

    /**
     * Execute the core function.
     *
     * @return void
     */
    abstract public function execute();
}
