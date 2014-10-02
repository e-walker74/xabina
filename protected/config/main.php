<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    // autoloading model and component classes
	'id' => 'xabina',
    'onBeginRequest' => function($event) {
        $route = Yii::app()->getRequest()->getPathInfo();
        $module = substr($route, 0, strpos($route, '/'));

        if (Yii::app()->hasModule($module)) {
            $module = Yii::app()->getModule($module);
            if (isset($module->urlRules)) {
                $urlManager = Yii::app()->getUrlManager();
                $urlManager->addRules($module->urlRules);
            }
        }
        return true;
    },
);