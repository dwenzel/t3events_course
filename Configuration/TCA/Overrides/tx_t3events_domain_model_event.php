<?php

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

$temporaryColumns = [
	// obosolete? (teaser)
	'abstract' => [
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.abstract',
		'config' => [
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		]
	],
	'goals' => [
		'exclude' => 0,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.goals',
		'config' => [
			'type' => 'text',
			'cols' => 32,
			'rows' => 10,
			'eval' => 'trim'
		],
		'defaultExtras' => 'richtext[]'
	],
	'requirements' => [
		'exclude' => 0,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.requirements',
		'config' => [
			'type' => 'text',
			'cols' => 32,
			'rows' => 10,
			'eval' => 'trim'
		],
		'defaultExtras' => 'richtext[]'
	],
	'listview_exclusion' => [
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.listview_exclusion',
		'config' => [
			'type' => 'check',
		]
	],
	'exam_costs' => [
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.exam_costs',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'eval' => 'double2'
		]
	],
	'exam_remarks' => [
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.exam_remarks',
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
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.degree_type',
		'config' => [
			'type' => 'select',
			'items' => [
				[$ll . 'tx_dakosyreservations_domain_model_course.degree_type.0', 0],
				[$ll . 'tx_dakosyreservations_domain_model_course.degree_type.1', 1],
				[$ll . 'tx_dakosyreservations_domain_model_course.degree_type.2', 2],
				[$ll . 'tx_dakosyreservations_domain_model_course.degree_type.3', 3],
				[$ll . 'tx_dakosyreservations_domain_model_course.degree_type.4', 4],
			],
		],
	],
	// todo model instruction form?
	'mode_instructionform' => [
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform',
		'config' => [
			'type' => 'select',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'items' => [
				[$ll . '', '--div--'], // [no label]
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.6', 6], // auf Anfrage / Sonstiges

				[$ll . '', '--div--'], // [no label]
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.1', 1], // Präsenzseminar
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.103', 103], // Vollzeit
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.104', 104], // Teilzeit
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.105', 105], // Wochenendveranstaltung
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.106', 106], // Blockunterricht
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.107', 107], // Inhouse/Firmenseminar

				[$ll . '', '--div--'], // [no label]
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.2', 2], // E-Learning/Blended Learning/Selbststudium
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.3', 3], // Blended Learning
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.11', 11], // Selbststudium
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.15', 15], // E-Learning

				[$ll . '', '--div--'], // [no label]
				[$ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.4', 4], // Fernunterricht/Fernstudium
			],
			'noIconsBelowSelect' => 1,
		]
	],
	'certificate' => [
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.certificate',
		'config' => [
			'type' => 'select',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 1000,
			'items' => [
				[$ll . 'tx_dakosyreservations_domain_model_course.certificate.1', 1], // Maßnahmezertifizierung nach AZWV/AZAV (SGB III)
				[$ll . 'tx_dakosyreservations_domain_model_course.certificate.2', 2], // Bildungsurlaub (entsprechend der Gesetze der Bundesländer)
				[$ll . 'tx_dakosyreservations_domain_model_course.certificate.3', 3], // Sonstiges
				[$ll . 'tx_dakosyreservations_domain_model_course.certificate.4', 4], // AFBG (Meister-BAFöG)
			],
		],
	],
	// todo media field in t3events?
	'list_view_image' => [
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.list_view_image',
		'config' => [
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'sys_file',
			'MM' => 'sys_file_reference',
			'MM_match_fields' => [
				'fieldname' => 'list_view_image'
			],
			'prepend_tname' => TRUE,
			'appearance' => [
				'elementBrowserAllowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'elementBrowserType' => 'file'
			],
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'show_thumbs' => '1',
			'size' => '1',
			'maxitems' => '1',
			'minitems' => '0',
		],
	],
	'image_gallery' => [
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.image_gallery',
		'config' => [
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'sys_file',
			'MM' => 'sys_file_reference',
			'MM_match_fields' => [
				'fieldname' => 'image_gallery'
			],
			'prepend_tname' => TRUE,
			'appearance' => [
				'elementBrowserAllowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'elementBrowserType' => 'file'
			],
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'show_thumbs' => '1',
			'size' => '5',
			'maxitems' => '50',
			'minitems' => '0',
		],
	],
	/*
	'branch' => [
		'exclude' => 1,
		'l10n_mode' => 'mergeIfNotBlank',
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.branch',
		'config' => [
			'type' => 'select',
			'renderMode' => 'tree',
			'treeConfig' => [
				//'dataProvider' => 'GeorgRinger\\News\\TreeProvider\\DatabaseTreeDataProvider',
				'parentField' => 'parent',
				'rootUid' => 335,
				'appearance' => [
					'showHeader' => TRUE,
					'allowRecursiveMode' => TRUE,
					'expandAll' => TRUE,
					'maxLevels' => 99,
					'width' => 700,
				],
			],
			'MM' => 'sys_category_record_mm',
			'MM_match_fields' => [
				'fieldname' => 'branch',
				'tablenames' => 'tx_t3events_domain_model_event',
			],
			'MM_opposite_field' => 'items',
			'foreign_table' => 'sys_category',
			'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
			'size' => 10,
			'autoSizeMax' => 20,
			'minitems' => 0,
			'maxitems' => 99,
		]
	],
	*/
	'partner' => [
		'exclude' => 1,
		'label' => $ll . 'tx_t3eventscourse_domain_model_course.partner',
		'config' => [
			'type' => 'select',
			'foreign_table' => 'tx_t3events_domain_model_company',
			'foreign_table_where' => ' ORDER BY tx_t3events_domain_model_company.name',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 100,
		]
	],

	'program_agenda' => [
		'label' => $ll . 'tx_t3eventscourse_domain_model_course.program_agenda',
		'config' => [
			'type' => 'inline',
			'foreign_table' => 'tt_content',
			'foreign_label' => 'header',
			'foreign_default_sortby' => 'tt_content.date ASC',
			'MM' => 'tx_t3eventscourse_event_programagenda_mm',
			'minitems' => 0,
			'maxitems' => 9999,
			'appearance' => [
				'collapseAll' => TRUE,
				'expandSingle' => TRUE,
				'enabledControls' => [
					'info' => FALSE,
					'new' => FALSE,
					'sort' => FALSE,
					'hide' => FALSE,
					'delete' => TRUE,
					'localize' => FALSE,
				],
				'levelLinksPosition' => 'both',
			],
		],
	]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_event', $temporaryColumns);

//show items for type course
$itemsForCourseType = 'tx_extbase_type,headline,subtitle,new_until,teaser,event_type,genre,description,goals,requirements,keywords,
							mode_instructionform,
						--div--;' . $ll . 'tab.relations,
							audience,certificate,certificate_desc,course_contacts,contact_person,partner,
						--div--;' . $ll . 'tab.images,
							image,list_view_image,image_gallery,testimonials,
						--div--;' . $ll . 'tab.lessons,
							lessons,
						--div--;' . $ll . 'tab.exam_degree,
							exam_costs,exam_remarks,degree_type,
						--div--;' . $ll . 'tab.visibility,
							hidden,listview_exclusion,starttime,endtime,archive_date,fe_group';
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_T3eventsCourse_Course']['showitem'] = $itemsForCourseType;

// add types to type field items
$typeField = $GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['type'];
$GLOBALS['TCA']['tx_t3events_domain_model_event']['columns'][$typeField]['config']['items'][] =
	[$ll . 'tx_t3events_domain_model_event.tx_extbase_type.default', 1];
$GLOBALS['TCA']['tx_t3events_domain_model_event']['columns'][$typeField]['config']['items'][] =
	[$ll . 'tx_t3events_domain_model_event.tx_extbase_type.Tx_T3eventsCourse_Course', 'Tx_T3eventsCourse_Course'];

// EVENT TYPE: GENERAL EVENT TYPE
$itemsForDefaultType = 'tx_extbase_type,headline,subtitle,teaser,event_type,description,goals,requirements,program_agenda,keywords,
						--div--;' . $ll . 'tab.relations,
							audience,course_contacts,contact_person,partner,
						--div--;' . $ll . 'tab.images,
							image,list_view_image,image_gallery,testimonials,
						--div--;' . $ll . 'tab.lessons,
							performances,
						--div--;' . $ll . 'tab.visibility,
							sys_language_uid,hidden,listview_exclusion,starttime,endtime,archive_date,fe_group,';

$GLOBALS['TCA']['tx_t3events_domain_model_event']['types'][1]['showitem'] = $itemsForDefaultType;
