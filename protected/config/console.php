<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'import' => array(
        'application.models.mongo.*',
		'application.models.*',
        'application.components.*',
        'application.components.ConsoleCommand',
    ),
	'preload'=>array('log'),
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'EVNA Console app',
    'modules' => require(dirname(__FILE__) . '/modules.php'),
    'components' => require(dirname(__FILE__) . '/components.php'),
    'params' => CMap::mergeArray(require(dirname(__FILE__) . '/params.php'),
		array(
			'mail' => array(
				'time_limit' => 50 // время отработки воркера (обновление в кроне - раз в минуту)
			),
			'likes' => array(
				'time_limit' => 60 * 9 // 9 минут на обновление лайков (обновление в кроне - раз в 10 минут)
			),
			//'socialBaseUrl' => 'http://www.social.migom.by/',
			//'yamaBaseUrl' => 'http://www.yama.migom.by/',
		)
	),

);