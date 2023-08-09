<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('t3events_course', 'Configuration/TypoScript', 'Courses');

$settings = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['t3events_course'];

if (!empty($settings['includeGoogleMaps'])) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:t3events_course/Resources/Private/TypoScript/googleMaps.ts">');
}

if (!empty($settings['includeJavaScript'])) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:t3events_course/Resources/Private/TypoScript/loadMapJs.ts">');
}

