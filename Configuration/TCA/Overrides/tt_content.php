<?php

$extName = 't3events_course';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $extName,
    'Courses',
    'Courses'
);

$pluginSignature = str_replace('_', '', $extName) . '_courses';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extName . '/Configuration/FlexForms/flexform_courses.xml');



