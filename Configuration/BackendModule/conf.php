<?php
/**
 * Configuration for Backend Modul Group
*/
define('TYPO3_MOD_PATH', '../typo3conf/ext/dakosy_reservations/Configuration/BackendModule/');
$MCONF['name'] = 'courses';
$MCONF['script'] = '_DISPATCH';
$MCONF['access'] = 'user,group';
$MLANG['default']['tabs_images']['tab'] = 'ext_icon.gif';
$MLANG['default']['ll_ref'] = 'LLL:EXT:dakosy_reservations/Resources/Private/Language/locallang_mod_main.xlf';
?>