<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_dakosyreservations_domain_model_notification'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_dakosyreservations_domain_model_notification']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, recipient, sender, subject, bodytext, format, sent_at',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, recipient, sender,  subject, bodytext, format, sent_at'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'recipient' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_notification.recipient',
			'config' => array(
				'readOnly' => '1',
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,nospace'
			),
		),
		'reservation' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_notification.reservation',
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'sender' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_notification.sender',
			'config' => array(
				'readOnly' => '1',
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,nospace',
			),
		),
		'subject' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_notification.subject',
			'config' => array(
				'type' => 'input',
				'readOnly' => '1',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'bodytext' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_notification.bodytext',
			'config' => array(
				'type' => 'text',
				'readOnly' => '1',
				'cols' => 30,
				'rows' => 15,
			),
		),
		'format' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_notification.format',
			'config' => array(
				'type' => 'input',
				'readOnly' => '1',
				'size' => 30,
				'eval' => 'trim,nospace',
			),
		),
		'sent_at' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_notification.send_at',
			'config' => array(
				'type' => 'input',
				'readOnly' => '1',
				'size' => 7,
				'default' => '0',
				'eval' => 'datetime'
			),
		),
	),
);
