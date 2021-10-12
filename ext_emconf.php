<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "jobapplications".
 *
 * Auto generated 28-09-2021 16:00
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

    $EM_CONF[$_EXTKEY] = array (
		'title' => 'Jobapplications',
		'description' => 'This extension enables you to manage job postings, provides you with an application form and a backend module to manage incoming applications.',
		'category' => 'plugin',
		'author' => 'Stefanie Döll, Benjamin Jasper',
		'author_company' => 'it.x informationssysteme gmbh',
		'author_email' => 'typo-itx@itx.de',
		'state' => 'stable',
		'uploadfolder' => true,
		'createDirs' => '',
		'clearCacheOnLoad' => 1,
		'version' => '1.0.3',
		'constraints' => [
			'depends' => [
				'typo3' => '9.5.0 - 10.4.99',
				'vhs' => '6.0.0 - 6.2.99',
			],
			'conflicts' => [],
			'suggests' => [],
		],
	];
