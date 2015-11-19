<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
if (!empty($settings['includeGoogleMaps'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/googleMaps.ts">');
}
if (!empty($settings['includeJavaScript'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/loadMapJs.ts">');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Cps.' . $_EXTKEY,
	'Courses',
	array(
		'Course' => 'list, show, filter',
		'Lesson' => 'list, show, filter',
	),
	// non-cacheable actions
	array(
		'Course' => 'filter',
		'Lesson' => 'filter,list',
	)
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Cps.' . $_EXTKEY,
	'Pi1',
	array(
		'Reservation' => 'new, show, create, checkout, confirm, delete, newParticipant, createParticipant, removeParticipant',
	),
	// non-cacheable actions
	array(
		'Reservation' => 'new, show, create, checkout, confirm, delete, newParticipant, createParticipant, removeParticipant',
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Cps\\DakosyReservations\Command\\CloseBookingCommandController';
/**
 * Hook um eigenes JavaScript im BE hinzuzufügen
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/template.php']['preHeaderRenderHook'][] =
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Classes/Hooks/Backend/TemplateHook.php:TemplateHook->addBackendJavaScript';
