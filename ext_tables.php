<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
    \CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration::registerAndConfigureModules();
}

\CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration::configureTables();
