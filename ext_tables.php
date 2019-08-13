<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

if (TYPO3_MODE === 'BE') {
    $versionNumber = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
    $pathCourseIcon = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/open-book.svg';
    $pathScheduleIcon = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/calendar-blue.svg';
    if ($versionNumber < 7000000) {
        $pathCourseIcon = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module_icon_course.png';
        $pathScheduleIcon = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module_icon_schedule.png';
    }

    /**
	 * Register Backend Modules
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CPSIT.' . $_EXTKEY,
		'T3eventsEvents',
		'm4',
		'',
		[
			'Backend\CourseBackend' => 'list, show,reset,new',
		],
		[
			'access' => 'user,group',
			'icon' => $pathCourseIcon,
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m4.xlf',
		]
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'CPSIT.' . $_EXTKEY,
		'T3eventsEvents',
		'm2',
        '',
        [
			'Backend\ScheduleBackend' => 'list, show, edit, delete,reset',
		],
		[
			'access' => 'user,group',
			'icon' => $pathScheduleIcon,
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

unset($pathScheduleIcon, $pathCourseIcon, $pluginSignature, $ll);
