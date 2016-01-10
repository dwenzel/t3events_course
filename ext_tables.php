<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

if (TYPO3_MODE === 'BE') {
	$moduleName = 'courses';
	if (!isset($TBE_MODULES[$moduleName])) {
		$temp_TBE_MODULES = array();
		foreach ($TBE_MODULES as $key => $val) {
			if ($key == 'web') {
				$temp_TBE_MODULES[$key] = $val;
				$temp_TBE_MODULES[$moduleName] = '';
			} else {
				$temp_TBE_MODULES[$key] = $val;
			}
		}
		$TBE_MODULES = $temp_TBE_MODULES;
	}

	/**
	 * add main module
	 */
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		$moduleName,
		'',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/BackendModule/'
	);

	/**
	 * Register Backend Modules
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CPSIT.' . $_EXTKEY,
		'courses',     // Make module a submodule of 'courses'
		'm4',    // Submodule key
		'',        // Position
		array(
			'Backend\CourseBackend' => 'list, show',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module_icon_course.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m4.xlf',
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CPSIT.' . $_EXTKEY,
		'courses',     // Make module a submodule of 'courses'
		'm2',    // Submodule key
		'',        // Position
		array(
			'Backend\ScheduleBackend' => 'list, show, edit, delete',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module_icon_schedule.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m2.xlf',
		)
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


// rename the table (this affects all types...)
$TCA['tx_t3events_domain_model_event']['ctrl']['title'] = $ll . 'tx_t3eventscourse_domain_model_course';
$TCA['tx_t3events_domain_model_genre']['ctrl']['title'] = $ll . 'tx_t3eventscourse_domain_model_genre';



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3eventscourse_domain_model_certificate');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_t3eventscourse_domain_model_certificatetype');

