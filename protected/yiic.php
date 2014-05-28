<?php
//apc_clear_cache();
// change the following paths if necessary

require_once dirname(__FILE__).'/../defines.php';

$config=dirname(__FILE__).'/config/console.php';
defined('YII_DEBUG') or define('YII_DEBUG',true);

if (YII_DEBUG === true) {
    include_once CORE_PATH.'functions.php';
}
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

require_once(FRAMEWORK_PATH.'yii.php');
require_once(CORE_PATH.'YiiBaseEx.php');

Yii::setPathOfAlias("core", rtrim(CORE_PATH,'/'));
Yii::getLogger()->autoDump = true;
Yii::getLogger()->autoFlush=1;
if(isset($config))
{
	$app=Yii::createConsoleApplication($config);
	$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
}
else
	$app=Yii::createConsoleApplication(array('basePath'=>dirname(__FILE__).'/cli'));

spl_autoload_unregister(array('YiiBase', 'autoload'));
spl_autoload_register(array('YiiBaseEx', 'autoload'));



$env=@getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
	$app->commandRunner->addCommands($env);

$app->run();
