<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
if (!empty($settings['includeGoogleMaps'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Resources/Private/TypoScript/googleMaps.ts">');
}
if (!empty($settings['includeJavaScript'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Resources/Private/TypoScript/loadMapJs.ts">');
}

\CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration::configurePlugins();
