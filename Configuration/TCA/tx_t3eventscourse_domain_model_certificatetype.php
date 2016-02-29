<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xml:';

return [
	'ctrl' => [
		'title' => $ll . 'tx_t3eventscourse_domain_model_certificatetype',
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
		'enablecolumns' => [
			'disabled' => 'hidden',

		],
		'searchFields' => 'title,description,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('t3events_course')
			. 'Resources/Public/Icons/tx_t3eventscourse_domain_model_certificatetype.gif'
	], 'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, description;;;richtext:rte_transform[mode=ts_links], '],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

		'sys_language_uid' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => [
					['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
					['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0]
				],
			],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_t3eventscourse_domain_model_certificatetype',
				'foreign_table_where' => 'AND tx_t3eventscourse_domain_model_certificatetype.pid=###CURRENT_PID### AND tx_t3eventscourse_domain_model_certificatetype.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		't3ver_label' => [
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			]
		],
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
			],
		],
		'title' => [
			'exclude' => 1,
			'label' => $ll . 'tx_t3eventscourse_domain_model_certificatetype.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'description' => [
			'exclude' => 1,
			'label' => $ll . 'tx_t3eventscourse_domain_model_certificatetype.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => [
					'RTE' => [
						'icon' => 'wizard_rte2.gif',
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'module' => [
							'name' => 'wizard_rte'
						],
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					]
				]
			],
		],

	],
];
