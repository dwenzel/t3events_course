<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:';

$GLOBALS['TCA']['tx_dakosyreservations_domain_model_reservation'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_dakosyreservations_domain_model_reservation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, status, company, contact, participants, lesson, notifications',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, status, company, contact, privacy_statement_accepted, offers_accepted, lesson,--div--;'. $ll . 'tabs.participants, participants, --div--;'. $ll . 'tabs.notifications, notifications, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
				'foreign_table' => 'tx_dakosyreservations_domain_model_reservation',
				'foreign_table_where' => 'AND tx_dakosyreservations_domain_model_reservation.pid=###CURRENT_PID### AND tx_dakosyreservations_domain_model_reservation.sys_language_uid IN (-1,0)',
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

		'status' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_dakosyreservations_domain_model_reservation.status',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array($ll . 'tx_dakosyreservations_domain_model_reservation.status.0', 0), // new - neu
					array($ll . 'tx_dakosyreservations_domain_model_reservation.status.1', 1), // draft - Entwurf
					array($ll . 'tx_dakosyreservations_domain_model_reservation.status.2', 2), // submitted - gebucht
					array($ll . 'tx_dakosyreservations_domain_model_reservation.status.3', 3), // canceled (no charge) - storniert (kostenlos)
					array($ll . 'tx_dakosyreservations_domain_model_reservation.status.4', 4), // canceled (with costs) - storniert (kostenpflichtig)
					array($ll . 'tx_dakosyreservations_domain_model_reservation.status.5', 5), // closed - abgeschlossen
					array($ll . 'tx_dakosyreservations_domain_model_reservation.status.6', 6), // canceled by DAKOSY- abgesagt durch DAKOSY
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'company' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_reservation.company',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dakosyreservations_domain_model_company',
				'foreign_table_field' => 'name',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'contact' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_reservation.contact',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dakosyreservations_domain_model_person',
				'foreign_table_field' => 'name',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'participants' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_reservation.participants',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dakosyreservations_domain_model_person',
				'MM' => 'tx_dakosyreservations_reservation_participants_person_mm',
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
		'contact_is_participant' => array(
			'label' => $ll . 'tx_dakosyreservations_domain_model_reservation.contactIsParticipant',
			'config' => array(
				'type' => 'check',
				'default' => '0',
			),
		),
		'privacy_statement_accepted' => array(
			'label' => $ll . 'tx_dakosyreservations_domain_model_reservation.privacyStatementAccepted',
			'config' => array(
				'type' => 'check',
				'default' => '0',
				'readOnly' => 1,
			),
		),
		'offers_accepted' => array(
			'label' => $ll . 'tx_dakosyreservations_domain_model_reservation.offersAccepted',
			'config' => array(
				'type' => 'check',
				'default' => '0',
			),
		),
		'lesson' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_reservation.lesson',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_t3events_domain_model_performance',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'notifications' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xlf:tx_dakosyreservations_domain_model_reservation.notifications',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dakosyreservations_domain_model_notification',
				'foreign_field' => 'reservation',
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

	),
);
