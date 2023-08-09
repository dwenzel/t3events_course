<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration::configurePlugins();

/** @noinspection PhpUnhandledExceptionInspection */
\CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration::registerIcons();
