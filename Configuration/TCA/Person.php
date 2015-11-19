<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$ll = 'LLL:EXT:dakosy_reservations/Resources/Private/Language/locallang_db.xlf:';
$GLOBALS['TCA']['tx_dakosyreservations_domain_model_person'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_dakosyreservations_domain_model_person']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, gender, first_name, name, address, zip, city, phone, email, reservation',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden,type, gender, first_name, name, address, zip, city, phone, email, reservation'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_dakosyreservations_domain_model_person',
				'foreign_table_where' => 'AND tx_dakosyreservations_domain_model_person.pid=###CURRENT_PID### AND tx_dakosyreservations_domain_model_person.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

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
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'type' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array($ll . 'tx_dakosyreservations_domain_model_person.type.empty' , 0),
					array($ll . 'tx_dakosyreservations_domain_model_person.type.contact' , 1),
					array($ll . 'tx_dakosyreservations_domain_model_person.type.participant' , 2),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'gender' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.gender',
			'config' => array(
				'type' => 'radio',
				'items' => array(
					array($ll . 'tx_dakosyreservations_domain_model_person.gender.male' , 1),
					array($ll . 'tx_dakosyreservations_domain_model_person.gender.female' , 2),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'first_name' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.first_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'name' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'address' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.address',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'zip' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'phone' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_person.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'reservation' => array(
			'hidden' => 1,
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dakosyreservations_domain_model_reservation',
				'maxitems' => 1,
				'minitems' => 1,
				'readOnly' => 1
			),
		),
	),
);
