<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$ll = 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_db.xml:';
$rteWizardIconPath = 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif';
$linkWizardConfig = [
    'type' => 'popup',
    'title' => $ll . 'button.openLinkWizard',
    'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif',
    'module' => [
        'name' => 'wizard_link',
        'urlParameters' => [
            'mode' => 'wizard'
        ],
    ],
    'JSopenParams' => 'height=600,width=500,status=0,menubar=0,scrollbars=1'
];

/** @var \TYPO3\CMS\Core\Information\Typo3Version $typo3Version */
$typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);

if ($typo3Version->getMajorVersion() < 7) {
    $rteWizardIconPath = 'wizard_rte2.gif';
    $linkWizardConfig = [
        'type' => 'popup',
        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
        'icon' => 'link_popup.gif',
        'module' => [
            'name' => 'wizard_element_browser',
            'urlParameters' => [
                'mode' => 'wizard'
            ]
        ],
        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
    ];
}

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
		'iconfile' => 'EXT:t3events_course/Resources/Public/Icons/tx_t3eventscourse_domain_model_certificatetype.gif'
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid,l10n_parent, l10n_diffsource, hidden, --palette--;;1, title, description,richtext:rte_transform[mode=ts_links], '],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
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
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
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
                'enableRichtext' => true,
			],
		],
	],
];
