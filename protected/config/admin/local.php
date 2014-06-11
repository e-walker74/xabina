<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/../main.php'),
	array(
        'onBeginRequest' => function(){return true;},
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../..',
        'runtimePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../..'
        . DIRECTORY_SEPARATOR . 'runtime',
        'name' => 'XABINA',
		'language' => 'en',
        // preloading 'log' component
        'preload' => array('log'),
        'defaultController' => 'site',
        'components' => require(dirname(__FILE__) . '/components.php'),
        'import' => array(
            'application.models.*',
			'application.components.*',
			'application.widgets.*',
			'application.services.*',
			'application.modules.rights.*',
			'application.modules.rights.components.*',
        ),
        'modules' => require(dirname(__FILE__) . '/modules.php'),
		'params' => require(dirname(__FILE__) . '/../params.php'),
	)

);
