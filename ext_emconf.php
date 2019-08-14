<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3events_course".
 *
 * Auto generated 02-08-2017 13:30
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Courses',
	'description' => 'Manage courses and course schedules. Extends t3events ',
	'category' => 'plugin',
	'author' => 'Dirk Wenzel, Boerge Franck',
	'author_email' => 't3events@gmx.de, franck@cps-it.de',
	'state' => 'beta',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '0.10.0',
	'constraints' =>
	array (
		'depends' =>
		array (
            'typo3' => '8.7.0-9.5.99',
            't3events' => '1.1.0-0.0.0',
		),
		'conflicts' =>
		array (
		),
		'suggests' =>
		array (
		),
	)
);

