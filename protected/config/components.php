<?php

return array(
    'db'            => require(dirname(__FILE__) . '/components/db.php'),
    'session'       => require(dirname(__FILE__) . '/components/session.php'),
    'cache'         => require(dirname(__FILE__) . '/components/cache.php'),
    'log'           => require(dirname(__FILE__) . '/components/log.php'),
	'notify' => array(
		'class' => 'core.components.QUserNotify',
	),
	'dynamicRes'=>array(
		'class' => 'core.extensions.DynamicRes.DynamicRes',
		'urlConfig' => array( // Its fix Css, and convert Url to RealName 
			'baseUrl'  => '/', // Url of your Site (ending with /), modify it if you use subdomain
			'basePath' => dirname(__FILE__).'/../../', // path of your site (ending with /) (No Change This)
		)
	),
	'image' => array(
        'class' => 'core.extensions.image.CImageComponent',
        // GD or ImageMagick
        'driver' => 'GD',
        // ImageMagick setup path
        'params' => array('directory' => '/opt/local/bin'),
    ),
    /*'messages' => array(
        'class'=>'CPhpMessageSource',
        'basePath' => '../core/messages'
    ),*/
    'user' => array(
        // enable cookie-based authentication
        'allowAutoLogin' => false,
        'class' => 'WebUser',
        'loginUrl' => array('login'),
        'defaultRole' => 'guest',
    ),
    'authManager' => array(
        'class' => 'PhpAuthManager',
        'defaultRoles' => array('guest'),
    ),
	'mailer' => array(
        'class' => 'application.ext.mailer.EMailer',
        'pathViews' => 'application.ext.mailer..email',
        'pathLayouts' => 'application.ext.mailer.layouts',
                    'Host'          => 'smtp.mandrillapp.com',
                    'SMTPAuth'      => true,
                    'Username'      => 'evgeniy.kazak@gmail.com',
                    'Password'      => '0Cjk7TMQ1EV5UB9cwPRx3w',
					'SMTPSecure'	=> 'tls',
					'Port' 			=> 587,
        'From'   	=> 'noreply@xabina.intwall.com',
		'Sender' 	=> 'noreply@xabina.intwall.com',
		'CharSet' 	=> 'UTF-8',
		'Hostname' 	=> 'xabina.intwall.com',
		
    ),
    // uncomment the following to enable URLs in path-format
    'urlManager' => array(
        'urlFormat' => 'path',
        'showScriptName' => false,
        'rules' => array(
			'/remindsuccess' => 'site/remindsuccess',
			'/remind' => 'site/remind',
			'/registrationsuccess' => 'site/registrationSuccess',
			'/emailconfirm/<hash:\w+>' => 'user/emailconfirm',
			'/remove/notification/<code:\w+>' => 'user/deletenotification',
			'/banking' => 'banking/index',
			'/banking/accountsactivation' => '/banking/accountsactivation',
			'/account/' => 'site/registration',
			'/login' => '/site/login',
			'<action:(login|logout)>' => 'site/<action>',
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
			'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        ),
    ),
    'request' => array(
        'class' => 'QHttpRequest',
		'enableCsrfValidation' => true,
		'noCsrfValidationRoutes'=>array('banking/uploadactivationfile', 'banking/accountsactivation'),
    ),
    'errorHandler' => array(
        // use 'site/error' action to display errors
        'errorAction' => 'site/error',
    ),
);