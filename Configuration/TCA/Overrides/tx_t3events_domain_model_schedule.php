<?php

$temporaryColumns = array(
	'duration' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.duration',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'places' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.places',
		'config' => array(
			'type' => 'input',
			'size' => 4,
			'eval' => 'int'
		)
	),
	'course' => array(
		'config' => array(
			'label' => $ll . 'tx_dakosyreservations_domain_model_course',
			'type' => 'select',
			'foreign_table' => 'tx_t3events_domain_model_event',
			'readOnly' => 1,
		)
	),
	'date_remarks' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.date_remarks',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'class_time' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.class_time',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
	'tx_t3events_domain_model_performance',
	$temporaryColumns,
	TRUE
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tx_t3events_domain_model_performance', 'duration', '', 'after:end_date');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tx_t3events_domain_model_performance', 'date_remarks', '', 'after:end_date');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tx_t3events_domain_model_performance', 'places', '', 'after:date_remarks');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tx_t3events_domain_model_performance', 'class_time', '', 'after:places');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tx_t3events_domain_model_performance', 'course', '', 'before:date');
