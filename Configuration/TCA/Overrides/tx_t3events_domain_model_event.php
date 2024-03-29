<?php

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

$GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['type'] = 'tx_extbase_type';
$extbaseType = 'Tx_T3eventsCourse_Course';

//show items for type course
$courseShowItems = '
							event_type,headline,subtitle,teaser,genre,description,goals,requirements,
							mode_instruction_form,
						--div--;' . $ll . 'tab.relations,
							audience,certificate,certificate_desc,course_contacts,contact_person,keywords,
						--div--;' . $ll . 'tab.images,
							image,
						--div--;' . $ll . 'tab.performances,
							performances;' . $ll. 'tx_t3eventscourse_domain_model_event.performances,
						--div--;' . $ll . 'tab.exam_degree,
							exam_costs,exam_remarks,degree_type,certificate,
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
			'eval' => 'trim',
            'enableRichtext' => true
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
            'renderType' => 'selectSingle',
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
	'mode_instruction_form' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form',
		'config' => [
			'type' => 'select',
            'renderType' => 'selectSingle',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'items' => [
				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.6', 6], // auf Anfrage / Sonstiges

				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.1', 1], // Präsenzseminar
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.103', 103], // Vollzeit
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.104', 104], // Teilzeit
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.105', 105], // Wochenendveranstaltung
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.106', 106], // Blockunterricht
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.107', 107], // Inhouse/Firmenseminar

				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.2', 2], // E-Learning/Blended Learning/Selbststudium
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.3', 3], // Blended Learning
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.11', 11], // Selbststudium
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.15', 15], // E-Learning

				[$ll . '', '--div--'],
				[$ll . 'tx_t3eventscourse_domain_model_event.mode_instruction_form.4', 4], // Fernunterricht/Fernstudium
			],
			'showIconTable' => false,
		]
	],
	'certificate' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_event.certificate',
		'config' => [
			'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'size' => 6,
			'minitems' => 0,
			'maxitems' => 1000,
			'foreign_table' => 'tx_t3eventscourse_domain_model_certificate',
			'foreign_table_where' => 'AND tx_t3eventscourse_domain_model_certificate.sys_language_uid IN (-1,0)',
		],
	],
];

// add type field if missing
if (!isset($GLOBALS['TCA']['tx_t3events_domain_model_event']['columns']['tx_extbase_type'])) {
	$temporaryColumns['tx_extbase_type'] = [
		'config' => [
			'label' => $ll . 'tx_t3events_domain_model_event.tx_extbase_type',
			'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
				[$ll. 'label.tx_extbase_type.default', '1'],
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

