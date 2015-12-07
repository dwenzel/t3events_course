<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Reservations'
);

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

if (TYPO3_MODE === 'BE') {
	$modulName = 'courses';
	if (!isset($TBE_MODULES[$modulName])) {
		$temp_TBE_MODULES = array();
		foreach ($TBE_MODULES as $key => $val) {
			if ($key == 'web') {
				$temp_TBE_MODULES[$key] = $val;
				$temp_TBE_MODULES[$modulName] = '';
			} else {
				$temp_TBE_MODULES[$key] = $val;
			}
		}
		$TBE_MODULES = $temp_TBE_MODULES;
	}

	/**
	 * add main module
	 */
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule($modulName, '', '', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/BackendModule/');

	/**
	 * Register Backend Modules
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Cps.' . $_EXTKEY,
		'courses',	 // Make module a submodule of 'courses'
		'm4',	// Submodule key
		'',		// Position
		array(
			'CourseBackend' => 'list, show',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/dakosy_icon_schulungen.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m4.xlf',
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Cps.' . $_EXTKEY,
		'courses',	 // Make module a submodule of 'courses'
		'm2',	// Submodule key
		'',		// Position
		array(
			'LessonBackend' => 'list, show, edit, delete',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/dakosy_icon_termine.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m2.xlf',
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Cps.' . $_EXTKEY,
		'courses',	 // Make module a submodule of 'courses'
		'm1',	// Submodule key
		'',						// Position
		array(
			'Bookings' => 'list, show, edit, update, cancel, delete, newParticipant, createParticipant, editParticipant, removeParticipant, newNotification, createNotification',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/dakosy_icon_buchungen.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m1.xlf',
			//'navigationComponentId' => 'typo3-pagetree'
		)
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Cps.' . $_EXTKEY,
		'courses',	 // Make module a submodule of 'courses'
		'm3',	// Submodule key
		'',						// Position
		array(
			'Participant' => 'list, download',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/dakosy_icon_teilnehmer.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m3.xlf',
			//'navigationComponentId' => 'typo3-pagetree'
		)
	);

}
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Cps.' . $_EXTKEY,
	'Courses',
	'Courses'
);

$pluginSignature = str_replace('_', '', $_EXTKEY) . '_courses';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_courses.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'DAKOSY Reservations');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_audience', 'EXT:t3events_course/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_audience.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dakosyreservations_domain_model_audience');
$GLOBALS['TCA']['tx_dakosyreservations_domain_model_audience'] = array(
	'ctrl' => array(
		'title'	=> $ll . 'tx_dakosyreservations_domain_model_audience',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',

		),
		'searchFields' => 'title,description,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Audience.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dakosyreservations_domain_model_audience.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_person', 'EXT:t3events_course/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_person.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dakosyreservations_domain_model_person');
$GLOBALS['TCA']['tx_dakosyreservations_domain_model_person'] = array(
	'ctrl' => array(
		'title'	=> $ll . 'tx_dakosyreservations_domain_model_person',
		'label' => 'name',
		'label_alt' => 'first_name',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,address,zip,city,phone,email',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Person.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dakosyreservations_domain_model_person.gif'
	),
);

//
if (!isset($GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['type'])) {
	if (file_exists($GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['dynamicConfigFile'])) {
		require_once($GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['dynamicConfigFile']);
	}
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$GLOBALS['TCA']['tx_t3events_domain_model_event']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => $ll . 'tx_dakosyreservations.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(),
			'size' => 1,
			'maxitems' => 1,
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_event', $tempColumns);

}

//if (!isset($GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type'])) {
if (file_exists($GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['dynamicConfigFile'])) {
	require_once($GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['dynamicConfigFile']);
}
// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type'] = 'tx_extbase_type';
$tempColumns = array();
$tempColumns[$GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type']] = array(
	'exclude' => 1,
	'label'   => $ll . 'tx_dakosyreservations.tx_extbase_type',
	'config' => array(
		'type' => 'select',
		'items' => array(),
		'size' => 1,
		'maxitems' => 1,
	)
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_performance', $tempColumns);
//}

$tmp_dakosy_reservations_columns = array(

	'deadline' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.deadline',
		'config' => array(
			'type' => 'input',
			'size' => 7,
			'eval' => 'date',
			'checkbox' => 1,
			'default' => time()
		),
	),
	'registration_begin' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.registration_begin',
		'config' => array(
			'type' => 'input',
			'size' => 7,
			'eval' => 'date',
			'checkbox' => 1
		),
	),
	'date_end' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.date_end',
		'config' => array(
			'type' => 'input',
			'size' => 7,
			'eval' => 'date',
			'checkbox' => 1
		),
	),
	'duration' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.duration',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'price' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.price',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'double2'
		)
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
	'free_of_charge' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.free_of_charge',
		'config' => array(
			'type' => 'check',
			'default' => '0'
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
	// t3events_register
	'registration_remarks' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.registration_remarks',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	// t3events_course
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
	// t3events_register
	'document_based_registration' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.document_based_registration',
		'config' => array(
			'type' => 'check',
			'default' => '0'
		)
	),
	// t3events_register
	'external_registration' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.external_registration',
		'config' => array(
			'type' => 'check',
			'default' => '1'
		)
	),
	'external_registration_link' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.external_registration_link',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		)
	),
	'registration_documents' => array(
		'label' => $ll . 'tx_dakosyreservations_domain_model_lesson.registration_documents',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'sys_file',
			'MM' => 'sys_file_reference',
			'MM_match_fields' => array(
				'fieldname' => 'registration_documents'
			),
			'prepend_tname' => TRUE,
			'appearance' => array(
				'elementBrowserAllowed' => 'doc,dox,pdf',
				'elementBrowserType' => 'file'
			),
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'show_thumbs' => '1',
			'size' => '3',
			'minitems' => '0',
			'maxitems' => '200',
			'autoSizeMax' => 40,
		),
	),
);

/*$tmp_dakosy_reservations_columns['course'] = array(
	'config' => array(
		'type' => 'passthrough',
	)
);
*/

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_performance',$tmp_dakosy_reservations_columns);

$tmp_dakosy_reservations_columns = array(

	'abstract' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.abstract',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		)
	),
	'audience' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.audience',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_dakosyreservations_domain_model_audience',
			'MM' => 'tx_dakosyreservations_course_audience_mm',
			'size' => 10,
			'autoSizeMax' => 30,
			'maxitems' => 9999,
			'multiple' => 0,
			'wizards' => array(
				'_PADDING' => 1,
				'_VERTICAL' => 1,
				'edit' => array(
					'type' => 'popup',
					'title' => 'Edit',
					'script' => 'wizard_edit.php',
					'icon' => 'edit2.gif',
					'popup_onlyOpenIfSelected' => 1,
					'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
				),
				'add' => Array(
					'type' => 'script',
					'title' => 'Create new',
					'icon' => 'add.gif',
					'params' => array(
						'table' => 'tx_dakosyreservations_domain_model_audience',
						'pid' => '###CURRENT_PID###',
						'setValue' => 'prepend'
					),
					'script' => 'wizard_add.php',
				),
			),
		),
	),
	'lessons' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.lessons',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_t3events_domain_model_performance',
			'foreign_field' => 'course',
			'maxitems'      => 9999,
			'appearance' => array(
				'collapseAll' => 1,
				'expandSingle' => 1,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'useSortable' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
	'newUntil' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.newUntil',
		'config' => array(
			'type' => 'input',
			'size' => '15',
			'max' => '20',
			'eval' => 'datetime',
			'default' => '0'
		)
	),
	'archivedate' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.archivedate',
		'config' => array(
			'type' => 'input',
			'size' => '15',
			'max' => '20',
			'eval' => 'date',
			'default' => '0'
		)
	),
	'goals' => array(
		'exclude' => 0,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.goals',
		'config' => array(
			'type' => 'text',
			'cols' => 32,
			'rows' => 10,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),
	'requirements' => array(
		'exclude' => 0,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.requirements',
		'config' => array(
			'type' => 'text',
			'cols' => 32,
			'rows' => 10,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),
	/*
	'targetgroup_desc' => array(
		'exclude' => 0,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.targetgroup_desc',
		'config' => array(
			'type' => 'text',
			'cols' => 32,
			'rows' => 10,
			'eval' => 'trim'
		),
		'defaultExtras' => 'richtext[]'
	),
	*/
	'listview_exclusion' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.listview_exclusion',
		'config' => array(
			'type' => 'check',
		)
	),
	'export_openqcat' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.export_openqcat',
		'config' => array(
			'type' => 'check',
			'default' => '1'
		)
	),
	'export_wis' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.export_wis',
		'config' => array(
			'type' => 'check',
			'default' => '1'
		)
	),
	'export_bison' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.export_bison',
		'config' => array(
			'type' => 'check',
			'default' => '1'
		)
	),
	'export_rce' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.export_rce',
		'config' => array(
			'type' => 'check',
			'default' => '1'
		)
	),
	'export_ea' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.export_ea',
		'config' => array(
			'type' => 'check',
			'default' => '0'
		)
	),
	'export_print' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.export_print',
		'config' => array(
			'type' => 'check',
			'default' => '1'
		)
	),
	'exam_costs' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.exam_costs',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'double2'
		)
	),
	'exam_remarks' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.exam_remarks',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 5,
			'eval' => 'trim'
		)
	),
	'degree_type' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.degree_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array($ll . 'tx_dakosyreservations_domain_model_course.degree_type.0', 0),
				array($ll . 'tx_dakosyreservations_domain_model_course.degree_type.1', 1),
				array($ll . 'tx_dakosyreservations_domain_model_course.degree_type.2', 2),
				array($ll . 'tx_dakosyreservations_domain_model_course.degree_type.3', 3),
				array($ll . 'tx_dakosyreservations_domain_model_course.degree_type.4', 4),
			),
		),
	),
	'mode_instructionform' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform',
		'config' => array(
			'type' => 'select',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'items' => array(
				array($ll . '', '--div--'), // [no label]
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.6', 6), // auf Anfrage / Sonstiges

				array($ll . '', '--div--'), // [no label]
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.1', 1), // Präsenzseminar
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.103', 103), // Vollzeit
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.104', 104), // Teilzeit
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.105', 105), // Wochenendveranstaltung
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.106', 106), // Blockunterricht
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.107', 107), // Inhouse/Firmenseminar

				array($ll . '', '--div--'), // [no label]
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.2', 2), // E-Learning/Blended Learning/Selbststudium
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.3', 3), // Blended Learning
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.11', 11), // Selbststudium
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.15', 15), // E-Learning

				array($ll . '', '--div--'), // [no label]
				array($ll . 'tx_dakosyreservations_domain_model_course.mode_instructionform.4', 4), // Fernunterricht/Fernstudium
			),
			'noIconsBelowSelect' => 1,
		)
	),
	'certificate' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.certificate',
		'config' => array(
			'type' => 'select',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 1000,
			'items' => array(
				array($ll . 'tx_dakosyreservations_domain_model_course.certificate.1', 1), // Maßnahmezertifizierung nach AZWV/AZAV (SGB III)
				array($ll . 'tx_dakosyreservations_domain_model_course.certificate.2', 2), // Bildungsurlaub (entsprechend der Gesetze der Bundesländer)
				array($ll . 'tx_dakosyreservations_domain_model_course.certificate.3', 3), // Sonstiges
				array($ll . 'tx_dakosyreservations_domain_model_course.certificate.4', 4), // AFBG (Meister-BAFöG)
			),
		),
	),
	'certificate_desc' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.certificate_desc',
		'config' => array(
			'type' => 'select',
			//'foreign_table' => 'tx_wispascourse_certificate_desc',
			//'foreign_table_where' => 'AND tx_wispascourse_certificate_desc.cd_course>0 AND tx_wispascourse_certificate_desc.cd_course = ###THIS_UID### ORDER BY tx_wispascourse_certificate_desc.cd_desc',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 100,
			'wizards' => array(
				'_PADDING' => 2,
				'_VERTICAL' => 1,

				'add' => array(
					'type' => 'script',
					'title' => 'Neue Fördermöglichkeit anlegen',
					'icon' => 'add.gif',
					'params' => array(
						'table' => 'tx_wispascourse_certificate_desc',
						'pid' => '68',
						'setValue' => 'prepend'
					),
					'JSopenParams' => 'height=600,width=800,status=0,menubar=0,scrollbars=1,resizable=yes',
					'script' => 'wizard_add.php',
				),

			),

		)
	),

	'list_view_image' => array(
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.list_view_image',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'sys_file',
			'MM' => 'sys_file_reference',
			'MM_match_fields' => array(
				'fieldname' => 'list_view_image'
			),
			'prepend_tname' => TRUE,
			'appearance' => array(
				'elementBrowserAllowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'elementBrowserType' => 'file'
			),
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'show_thumbs' => '1',
			'size' => '1',
			'maxitems' => '1',
			'minitems' => '0',
		),
	),
	'image_gallery' => array(
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.image_gallery',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'sys_file',
			'MM' => 'sys_file_reference',
			'MM_match_fields' => array(
				'fieldname' => 'image_gallery'
			),
			'prepend_tname' => TRUE,
			'appearance' => array(
				'elementBrowserAllowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'elementBrowserType' => 'file'
			),
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'show_thumbs' => '1',
			'size' => '5',
			'maxitems' => '50',
			'minitems' => '0',
		),
	),

	'testimonials' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.testimonials',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_cpstestimonials',
			'foreign_table_where' => ' AND tx_cpstestimonials.pid=###PAGE_TSCONFIG_IDLIST### ORDER BY tx_cpstestimonials.lastname,tx_cpstestimonials.firstname',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 100,
		)
	),
	/*
	'branch' => array(
		'exclude' => 1,
		'l10n_mode' => 'mergeIfNotBlank',
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.branch',
		'config' => array(
			'type' => 'select',
			'renderMode' => 'tree',
			'treeConfig' => array(
				//'dataProvider' => 'GeorgRinger\\News\\TreeProvider\\DatabaseTreeDataProvider',
				'parentField' => 'parent',
				'rootUid' => 335,
				'appearance' => array(
					'showHeader' => TRUE,
					'allowRecursiveMode' => TRUE,
					'expandAll' => TRUE,
					'maxLevels' => 99,
					'width' => 700,
				),
			),
			'MM' => 'sys_category_record_mm',
			'MM_match_fields' => array(
				'fieldname' => 'branch',
				'tablenames' => 'tx_t3events_domain_model_event',
			),
			'MM_opposite_field' => 'items',
			'foreign_table' => 'sys_category',
			'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
			'size' => 10,
			'autoSizeMax' => 20,
			'minitems' => 0,
			'maxitems' => 99,
		)
	),
	*/
	'contact_person' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.contact_person',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_cpsansprechpartner',
			'foreign_table_where' => 'AND tx_cpsansprechpartner.pid IN (###PAGE_TSCONFIG_IDLIST###) ORDER BY tx_cpsansprechpartner.lastname,tx_cpsansprechpartner.firstname',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 100,
		)
	),
	'course_contacts' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.course_contacts',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_cpsansprechpartner',
			'foreign_table_where' => 'AND tx_cpsansprechpartner.pid IN (###PAGE_TSCONFIG_IDLIST###) ORDER BY tx_cpsansprechpartner.lastname,tx_cpsansprechpartner.firstname',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 100,
		)
	),
	'partner' => array(
		'exclude' => 1,
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.partner',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_dakosyreservations_domain_model_company',
			'foreign_table_where' => ' ORDER BY tx_dakosyreservations_domain_model_company.name',
			'size' => 6,
			'minitems' => 0,
			'maxitems' => 100,
		)
	),

	/*
	// TODO reservierter bezeichner
	'eventcategories' => array(
		'exclude' => 1,
		'l10n_mode' => 'mergeIfNotBlank',
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.eventcategories',
		'config' => array(
			'type' => 'select',
			'renderMode' => 'tree',
			'treeConfig' => array(
				//'dataProvider' => 'GeorgRinger\\News\\TreeProvider\\DatabaseTreeDataProvider',
				'parentField' => 'parent',
				'rootUid' => 335,
				'appearance' => array(
					'showHeader' => TRUE,
					'allowRecursiveMode' => TRUE,
					'expandAll' => TRUE,
					'maxLevels' => 99,
					'width' => 700,
				),
			),
			'MM' => 'sys_category_record_mm',
			'MM_match_fields' => array(
				'fieldname' => 'categories',
				'tablenames' => 'tx_t3events_domain_model_event',
			),
			'MM_opposite_field' => 'items',
			'foreign_table' => 'sys_category',
			'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
			'size' => 10,
			'autoSizeMax' => 20,
			'minitems' => 0,
			'maxitems' => 99,
		)
	),

	*/

	'program_agenda' => array(
		//'displayCond' => 'REC:NEW:false',
		'label' => $ll . 'tx_dakosyreservations_domain_model_course.program_agenda',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tt_content',
			'foreign_label' => 'header',
			'foreign_default_sortby' => 'tt_content.date ASC',
			//'foreign_field' => 'course',
			'MM' => 'tx_t3events_domain_model_event_programagenda_mm',
			'minitems' => 0,
			'maxitems' => 9999,
			'appearance' => array(
				'collapseAll' => TRUE,
				'expandSingle' => TRUE,
				'enabledControls' => array(
					'info' => FALSE,
					'new' => FALSE,
					'sort' => FALSE,
					'hide' => FALSE,
					'delete' => TRUE,
					'localize' => FALSE,
				),
				'levelLinksPosition' => 'both',
			),
		),
	),

);



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_event',$tmp_dakosy_reservations_columns);

#$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_DakosyReservations_Course']['showitem'] = $TCA['tx_t3events_domain_model_event']['types']['1']['showitem'];
// rename the table (this affects all types...)
$TCA['tx_t3events_domain_model_event']['ctrl']['title'] = $ll . 'tx_dakosyreservations_domain_model_course';
$TCA['tx_t3events_domain_model_genre']['ctrl']['title'] = $ll . 'tx_t3events_domain_model_genre';






// EVENT TYPE: COURSE
// ------------------
// TAB general "Grunddaten"
$temp_course_tca = 'tx_extbase_type,headline,subtitle,newUntil,teaser,event_type,genre,description,goals,requirements,keywords,mode_instructionform,';

// TAB Relations "Zielgruppen/Partner/Kontakte"
$temp_course_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.relations,audience,certificate,certificate_desc,course_contacts,contact_person,partner,';
//$temp_course_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.relations,audience,targetgroup_desc,certificate,certificate_desc,course_contacts,contact_person,partner,eventcategories,';

// TAB images "Bilder und Testimonials"
$temp_course_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.images,image,list_view_image,image_gallery,testimonials,';

// TAB schedules "Zeit- und Preisangaben"
$temp_course_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.lessons,lessons,';

// TAB registration "Prüfung und Abschluss"
$temp_course_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.exam_degree,exam_costs,exam_remarks,degree_type,';

// TAB access "Sichtbarkeit und Export"
$temp_course_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.visibility,hidden,listview_exclusion,starttime,endtime,archivedate,fe_group,export_openqcat,export_wis,export_bison,export_rce,export_ea,export_print';

// assign to TCA
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_DakosyReservations_Course']['showitem'] = $temp_course_tca;

$GLOBALS['TCA']['tx_t3events_domain_model_event']['columns'][$TCA['tx_t3events_domain_model_event']['ctrl']['type']]['config']['items'][] = array($ll . 'tx_t3events_domain_model_event.tx_extbase_type.default',1);
$GLOBALS['TCA']['tx_t3events_domain_model_event']['columns'][$TCA['tx_t3events_domain_model_event']['ctrl']['type']]['config']['items'][] = array($ll . 'tx_t3events_domain_model_event.tx_extbase_type.Tx_DakosyReservations_Course','Tx_DakosyReservations_Course');

// -------------------------------------------------------------------------------------------------------------------------------

// EVENT TYPE: GENERAL EVENT TYPE
// ------------------------------
// TAB general "Grunddaten"
$temp_event_tca = 'tx_extbase_type,headline,subtitle,teaser,event_type,description,goals,requirements,program_agenda,keywords,';

// TAB Relations "Zielgruppen/Partner/Kontakte"
$temp_event_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.relations,audience,course_contacts,contact_person,partner,';
//$temp_event_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.relations,audience,targetgroup_desc,course_contacts,contact_person,partner,eventcategories,';

// TAB images "Bilder und Testimonials"
$temp_event_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.images,image,list_view_image,image_gallery,testimonials,';

// TAB schedules "Zeit- und Preisangaben"
$temp_event_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.lessons,performances,';

// TAB access "Sichtbarkeit und Export"
$temp_event_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_course.tab.visibility,sys_language_uid,hidden,listview_exclusion,starttime,endtime,archivedate,fe_group,export_rce,export_ea,';

// assign to TCA
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types'][1]['showitem'] = $temp_event_tca;




//$TCA['tx_t3events_domain_model_event']['columns']['tx_extbase_type']['config']['readOnly'] = 1;
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_t3events_domain_model_performance', $GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type'],'','after:endtime');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_reservation', 'EXT:t3events_course/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_reservation.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dakosyreservations_domain_model_reservation');
$GLOBALS['TCA']['tx_dakosyreservations_domain_model_reservation'] = array(
	'ctrl' => array(
		'title'	=> $ll . 'tx_dakosyreservations_domain_model_reservation',
		'label' => 'status',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'status,company,contact,participants,lesson,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Reservation.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dakosyreservations_domain_model_reservation.gif'
	),
);
//
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_company', 'EXT:t3events_course/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_company.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dakosyreservations_domain_model_company');
$GLOBALS['TCA']['tx_dakosyreservations_domain_model_company'] = array(
	'ctrl' => array(
		'title'	=> $ll . 'tx_dakosyreservations_domain_model_company',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,zip,address,city',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Company.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dakosyreservations_domain_model_company.gif'
	),
);


// extend lesson
//if (!isset($GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type'])) {
if (file_exists($GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['dynamicConfigFile'])) {
	require_once($GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['dynamicConfigFile']);
}
// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type'] = 'tx_extbase_type';
$tempColumns = array(
	'participants' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_reservation.participants',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_dakosyreservations_domain_model_person',
			'MM' => 'tx_dakosyreservations_lesson_participants_person_mm',
			'appearance' => array(
				'levelLinksPosition' => 'none',
				'enabledControls' => array(
					'info' => FALSE,
					'new' => FALSE,
					'dragdrop' => FALSE,
					'sort' => FALSE,
					'hide' => FALSE,
					'delete' => FALSE,
					'localize' => FALSE,
				),
			),
		),
	),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_performance', $tempColumns);
//}

$GLOBALS['TCA']['tx_t3events_domain_model_performance']['columns'][$TCA['tx_t3events_domain_model_performance']['ctrl']['type']]['config']['items'][] = array($ll . 'tx_t3events_domain_model_performance.tx_extbase_type.Tx_DakosyReservations_Lesson','Tx_DakosyReservations_Lesson');
// add type field to existing types
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types'][0]['showitem'] .= ',tx_extbase_type';
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types'][1]['showitem'] .= ',tx_extbase_type';

// add palettes
$TCA['tx_t3events_domain_model_performance']['palettes']['paletteLessonDates'] = array(
	'showitem' => 'date,date_end',
	'canNotCollapse' => TRUE,
);
$TCA['tx_t3events_domain_model_performance']['palettes']['paletteLessonRegistration'] = array(
	'showitem' => 'registration_begin,deadline',
	'canNotCollapse' => TRUE,
);
$TCA['tx_t3events_domain_model_performance']['palettes']['paletteLessonTime'] = array(
	'showitem' => 'begin, end, --linebreak--, duration',
	'canNotCollapse' => TRUE,
);

// SCHEDULE
// tab 'general'
$temp_schedule_tca = '--palette--;;paletteLessonDates,date_remarks,class_time,event_location,status,tx_extbase_type,course,';

// tab extended
$temp_schedule_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_lesson.tab.price,price,free_of_charge,price_notice,';

// tab registration "Anmeldung"
$temp_schedule_tca .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_lesson.tab.registration,--palette--;;paletteLessonRegistration,places,registration_remarks,document_based_registration,registration_documents,external_registration,external_registration_link,';

// tab 'participants'
$temp_schedule_tca .= '--div--;' . $ll . 'tx_dakosyreservation_domain_model_lesson.tab.participants,participants,';

$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] = $temp_schedule_tca;

// add sprite icons
\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(
	array(
		'download-excel-white' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/dakosy_icon_excel_weiss.png',
		'download-excel-blue' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/dakosy_icon_excel_blau.png',
	),
	$_EXTKEY
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_notification', 'EXT:t3events_course/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_notification.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dakosyreservations_domain_model_notification');
$GLOBALS['TCA']['tx_dakosyreservations_domain_model_notification'] = array(
	'ctrl' => array(
		'title'	=> $ll . 'tx_dakosyreservations_domain_model_notification',
		'label' => 'sent_at',
		'label_alt' => 'subject, recipient',
		'label_alt_force' => '1',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sent_at',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		//'languageField' => 'sys_language_uid',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'searchFields' => 'title,description,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Notification.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dakosyreservations_domain_model_notification.gif'
	),
);
