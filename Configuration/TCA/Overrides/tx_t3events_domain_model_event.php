<?php

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

$GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['type'] = 'tx_extbase_type';
$extbaseType = 'Tx_T3eventsCourse_Course';

//show items for type course
$courseShowItems = '
							headline,subtitle,teaser,event_type,genre,description,goals,requirements,
							mode_instructionform,
						--div--;' . $ll . 'tab.relations,
							audience,certificate,certificate_desc,course_contacts,contact_person,keywords,
						--div--;' . $ll . 'tab.images,
							image,
						--div--;' . $ll . 'tab.performances,
							performances;' . $ll. 'tx_t3eventscourse_domain_model_event.performances,
						--div--;' . $ll . 'tab.exam_degree,
							exam_costs,exam_remarks,degree_type,
						--div--;' . $ll . 'tab.visibility,
							tx_extbase_type,hidden,starttime,endtime,new_until,archive_date,fe_group';
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types'][$extbaseType]['showitem'] = $courseShowItems;

$temporaryColumns = [
	//'export_targets' => [],
	'requirements' => [
		'exclude' => 0,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.requirements',
		'config' => [
			'type' => 'text',
			'cols' => 32,
			'rows' => 10,
			'eval' => 'trim'
		],
		'defaultExtras' => 'richtext[]'
	],
	'exam_costs' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.exam_costs',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'eval' => 'double2'
		]
	],
	'exam_remarks' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.exam_remarks',
		'config' => [
			'type' => 'text',
			'cols' => 40,
			'rows' => 5,
			'eval' => 'trim'
		]
	],
	// todo model degree?
	'degree_type' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.degree_type',
		'config' => [
			'type' => 'select',
			'items' => [
				[$ll . 'tx_t3eventscourse_domain_model_event.degree_type.0', 0],
				[$ll . 'tx_t3eventscourse_domain_model_event.degree_type.1', 1],
				[$ll . 'tx_t3eventscourse_domain_model_event.degree_type.2', 2],
				[$ll . 'tx_t3eventscourse_domain_model_event.degree_type.3', 3],
				[$ll . 'tx_t3eventscourse_domain_model_event.degree_type.4', 4],
			],
		],
	],
	// todo model instruction form?
	'mode_instructionform' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform',
		'config' => [
			'type' => 'select',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'items' => [
				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.6', 6], // auf Anfrage / Sonstiges

				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.1', 1], // Präsenzseminar
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.103', 103], // Vollzeit
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.104', 104], // Teilzeit
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.105', 105], // Wochenendveranstaltung
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.106', 106], // Blockunterricht
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.107', 107], // Inhouse/Firmenseminar

				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.2', 2], // E-Learning/Blended Learning/Selbststudium
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.3', 3], // Blended Learning
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.11', 11], // Selbststudium
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.15', 15], // E-Learning

				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instructionform.4', 4], // Fernunterricht/Fernstudium
			],
			'noIconsBelowSelect' => 1,
		]
	],
	'certificate' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.certificate',
		'config' => [
			'type' => 'select',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 1000,
			'items' => [
				[$ll . 'tx_t3eventscourse_domain_model_event.certificate.1', 1], // Maßnahmezertifizierung nach AZWV/AZAV (SGB III)
				[$ll . 'tx_t3eventscourse_domain_model_event.certificate.2', 2], // Bildungsurlaub (entsprechend der Gesetze der Bundesländer)
				[$ll . 'tx_t3eventscourse_domain_model_event.certificate.3', 3], // Sonstiges
				[$ll . 'tx_t3eventscourse_domain_model_event.certificate.4', 4], // AFBG (Meister-BAFöG)
			],
		],
	],
];

// add type field if missing
if (!isset($GLOBALS['TCA']['tx_t3events_domain_model_event']['columns']['tx_extbase_type'])) {
	$temporaryColumns['tx_extbase_type'] = [
		'config' => [
			'label' => $ll . 'tx_t3events_domain_model_event.tx_extbase_type',
			'type' => 'select',
			'items' => [
				[$ll. 'label.tx_extbase_type.default', ''],
				[$ll . 'label.tx_extbase_type.Tx_T3eventsCourse_Course', $extbaseType]
			],
		]
	];
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
		'tx_t3events_domain_model_event', 'tx_extbase_type', '', 'before:hidden');
} else {
	// add type item
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
		'tx_t3events_domain_model_event',
		'tx_extbase_type',
		[$ll . 'label.tx_extbase_type.Tx_T3eventsCourse_Course', $extbaseType]

	);
}


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_event', $temporaryColumns);

