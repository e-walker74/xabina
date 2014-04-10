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
    'user' => array(
		'class'=>'RWebUser',
		'loginUrl' => array('/admin/default/login'),
		'authTimeout' => 60 * 5,
		'autoRenewCookie' => true,
    ),
    'authManager' => array(
		'class'=>'RDbAuthManager',
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
		'class' => 'UrlManager',
        'showScriptName' => false,
        'useStrictParsing' => false,
        'rules' => array(
            'rights' => '/admin/default/error',
            'admin/rights' => 'rights',
            'admin/rights/<controller:\w+>/<action:\w+>/<id:\d+>' => 'rights/<controller>/<action>',
            'admin/rights/<controller:\w+>/<action:\w+>' => 'rights/<controller>/<action>',
            /*'admin/<controller:\w+>/<id:\d+>' => 'admin/<controller>/view',
            'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
            'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',*/
        ),
    ),
    'errorHandler' => array(
        // use 'site/error' action to display errors
        'errorAction' => 'admin/default/error',
    ),
	'sms' => array(
		'class' => 'application.ext.sms.Sms',
		'login' => 'ekazak',
		'password' => '123456',
		'sendUrl' => 'http://www.spryng.nl/send.php',
		'sender' => 'XABINA',
		'route' => 'BUSINESS',
		'allowlong' => 1,
	),
);