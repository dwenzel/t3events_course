<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

if (TYPO3_MODE === 'BE') {
    \CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration::registerAndConfigureModules();
}
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'CPSIT.' . $_EXTKEY,
	'Courses',
	'Courses'
);

$pluginSignature = str_replace('_', '', $_EXTKEY) . '_courses';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_courses.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Courses');

\CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration::configureTables();

unset($pathScheduleIcon, $pathCourseIcon, $pluginSignature, $ll);
