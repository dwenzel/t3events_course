<?php
$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

$GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type'] = 'tx_extbase_type';

// add palettes
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['palettes']['paletteLessonDates'] = [
	'showitem' => 'date,end_date',
	'canNotCollapse' => TRUE,
];
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['palettes']['paletteLessonTime'] = [
	'showitem' => 'begin, end',
	'canNotCollapse' => TRUE,
];

// SCHEDULE
$lessonShowItems = '--palette--;;paletteLessonDates,
					--palette--;;paletteLessonTime,
						class_time,event_location,status,
					--div--;' . $ll . 'tab.price,
						price_notice,
					--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
						tx_extbase_type,hidden,starttime, endtime';

$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_T3eventsCourse_Schedule']['showitem'] = $lessonShowItems;

$temporaryColumns = [
	'class_time' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_performance.class_time',
		'config' => [
			'type' => 'text',
			'cols' => 40,
			'rows' => 5,
			'eval' => 'trim'
		]
	],
];

// add type field if missing
if (!isset($GLOBALS['TCA']['tx_t3events_domain_model_performance']['columns']['tx_extbase_type'])) {
	$temporaryColumns['tx_extbase_type'] = [
		'config' => [
			'label' => $ll . 'label.tx_extbase_type',
			'type' => 'select',
			'items' => [
				[$ll. 'label.tx_extbase_type.default', ''],
				[$ll. 'label.tx_extbase_type.Tx_T3eventsCourse_Schedule', 'Tx_T3eventsCourse_Schedule']
			],
		]
	];
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
		'tx_t3events_domain_model_performance', 'tx_extbase_type', '', 'before:hidden');
} else {
	// add type item
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
		'tx_t3events_domain_model_performance',
		'tx_extbase_type',
		[$ll. 'label.tx_extbase_type.Tx_T3eventsCourse_Schedule', 'Tx_T3eventsCourse_Schedule']
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
	'tx_t3events_domain_model_performance',
	$temporaryColumns,
	TRUE
);
