<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Reservations'
);

$ll = 'LLL:EXT:dakosy_reservations/Resources/Private/Language/locallang_db.xlf:';

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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_audience', 'EXT:dakosy_reservations/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_audience.xlf');
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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_person', 'EXT:dakosy_reservations/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_person.xlf');
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
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_t3events_domain_model_event',$tmp_dakosy_reservations_columns);

#$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_DakosyReservations_Course']['showitem'] = $TCA['tx_t3events_domain_model_event']['types']['1']['showitem'];
// rename the table (this affects all types...)
$TCA['tx_t3events_domain_model_event']['ctrl']['title'] = $ll . 'tx_dakosyreservations_domain_model_course';
$TCA['tx_t3events_domain_model_genre']['ctrl']['title'] = $ll . 'tx_t3events_domain_model_genre';
// tab general
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_DakosyReservations_Course']['showitem'] = 'event_type,headline,subtitle,abstract,tx_extbase_type,';
// tab extended
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_DakosyReservations_Course']['showitem'] .= '--div--;LLL:EXT:dakosy_reservations/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_course.tab.extended,description,audience,genre,keywords,';
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_DakosyReservations_Course']['showitem'] .= '--div--;LLL:EXT:dakosy_reservations/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_course.tab.lessons,lessons,';
//$GLOBALS['TCA']['tx_t3events_domain_model_event']['types']['Tx_DakosyReservations_Course']['showitem'] .= '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime';

$GLOBALS['TCA']['tx_t3events_domain_model_event']['columns'][$TCA['tx_t3events_domain_model_event']['ctrl']['type']]['config']['items'][] = array($ll . 'tx_t3events_domain_model_event.tx_extbase_type.default',1);
$GLOBALS['TCA']['tx_t3events_domain_model_event']['columns'][$TCA['tx_t3events_domain_model_event']['ctrl']['type']]['config']['items'][] = array($ll . 'tx_t3events_domain_model_event.tx_extbase_type.Tx_DakosyReservations_Course','Tx_DakosyReservations_Course');
$GLOBALS['TCA']['tx_t3events_domain_model_event']['types'][1]['showitem'] .= ',tx_extbase_type';
//$TCA['tx_t3events_domain_model_event']['columns']['tx_extbase_type']['config']['readOnly'] = 1;

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_t3events_domain_model_performance', $GLOBALS['TCA']['tx_t3events_domain_model_performance']['ctrl']['type'],'','after:endtime');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_reservation', 'EXT:dakosy_reservations/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_reservation.xlf');
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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_company', 'EXT:dakosy_reservations/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_company.xlf');
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
		'label' => 'LLL:EXT:dakosy_reservations/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_reservation.participants',
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
	'showitem' => 'date,deadline',
	'canNotCollapse' => TRUE,
);
$TCA['tx_t3events_domain_model_performance']['palettes']['paletteLessonTime'] = array(
	'showitem' => 'begin, end, --linebreak--, duration',
	'canNotCollapse' => TRUE,
);

// tab 'general'
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] = 'tx_extbase_type,course,--palette--;;paletteLessonDates, status,';
// tab extended
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] .= '--div--;' . $ll . 'tx_dakosyreservations_domain_model_lesson.tab.extended,';
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] .= 'event_location,--palette--;;paletteLessonTime, price, price_notice, places,';
// tab 'participants'
$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] .= '--div--;LLL:EXT:dakosy_reservations/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservation_domain_model_lesson.tab.participants,participants,';
// tab 'access'
//$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] .= '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime';

///
//$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] = $TCA['tx_t3events_domain_model_performance']['types']['1']['showitem'];

// tab extended
// tab 'access'
//$GLOBALS['TCA']['tx_t3events_domain_model_performance']['types']['Tx_DakosyReservations_Lesson']['showitem'] .= '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime';


///
//

// add sprite icons
\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(
	array(
		'download-excel-white' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/dakosy_icon_excel_weiss.png',
		'download-excel-blue' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/dakosy_icon_excel_blau.png',
	),
	$_EXTKEY
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dakosyreservations_domain_model_notification', 'EXT:dakosy_reservations/Resources/Private/Language/locallang_csh_tx_dakosyreservations_domain_model_notification.xlf');
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
