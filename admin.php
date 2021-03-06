<?php

require_once dirname(__FILE__).'/defines.php';

if(isset($_GET['evna_debug'])){
	defined('YII_DEBUG') or define('YII_DEBUG',true);
} else {
	defined('YII_DEBUG') or define('YII_DEBUG',true);
}

if(isset($_GET['debug']) && $_GET['debug'] == 777){
	define('YII_DEBUG',true);
}

// change the following paths if necessary
$yiiBase=dirname(__FILE__).'/framework/YiiBase.php';
$yiiEx  = dirname(__FILE__) . '/Yii.php';
$config=dirname(__FILE__).'/protected/config/admin/local.php';

// remove the following lines when in production mode

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if(YII_DEBUG === true){
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);

}

include_once dirname(__FILE__).'/functions.php';

require_once($yiiBase);
require_once($yiiEx);

$yii = Yii::createWebApplication($config);

Yii::getLogger()->autoDump = true;
Yii::getLogger()->autoFlush=1;

spl_autoload_unregister(array('YiiBase', 'autoload'));
spl_autoload_register(array('Yii', 'autoload'));
$yii->run();