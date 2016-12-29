<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

if (TYPO3_MODE === 'BE') {
	/**
	 * Register Backend Modules
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CPSIT.' . $_EXTKEY,
		'Events',
		'm4',
		'',
		[
			'Backend\CourseBackend' => 'list, show,reset',
		],
		[
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/open-book.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m4.xlf',
		]
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CPSIT.' . $_EXTKEY,
		'Events',
		'm2',
        '',
        [
			'Backend\ScheduleBackend' => 'list, show, edit, delete,reset',
		],
		[
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/calendar-blue.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m2.xlf',
		]
	);

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


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3eventscourse_domain_model_certificate');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3eventscourse_domain_model_certificatetype');

