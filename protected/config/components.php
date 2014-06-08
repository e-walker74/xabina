<?php

return array(
    'db'            => require(dirname(__FILE__) . '/components/db.php'),
    'session'       => require(dirname(__FILE__) . '/components/session.php'),
    'cache'         => require(dirname(__FILE__) . '/components/cache.php'),
    'log'           => require(dirname(__FILE__) . '/components/log.php'),
    'eauth'         => require(dirname(__FILE__) . '/components/eauth.php'),
    'notify' => array(
        'class' => 'core.components.QUserNotify',
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
		'authTimeout' => 60 * 75,
		'autoRenewCookie' => true,
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
		'class' => 'UrlManager',
        'showScriptName' => false,
        'rules' => array(
			'/gii' => 'gii',
			'/remindsuccess' => 'site/remindsuccess',
			'/remind' => 'site/remind',
			'/terms' => 'site/terms',
			'/registrationsuccess' => 'site/registrationSuccess',
			'/emailconfirm/<hash:\w+>' => 'user/emailconfirm',
			'/remove/notification/<code:\w+>' => 'user/deletenotification',
			'/banking' => 'banking/index',
			'/banking/verification' => 'verification/index',
			'/banking/accounts' => 'accounts/index',
			'/banking/accounts/balance' => 'accounts/cardbalance',
			'/banking/accounts/transaction/<id:[\w-]+>' => '/accounts/transaction',
			'/banking/accounts/transaction/<id:[\w-]+>/<exportType:(pdf|csv|doc)>' => '/accounts/transaction',
			'/banking/accounts/transaction/uploadattachemnt/<id:\w+>' => '/accounts/uploadattachemnt',
			'/banking/accounts/transaction/getattach/<name:[\w.]+>' => 'accounts/getattach',
			'/banking/accounts/transaction/onpdf/<id:[\w-]+>' => 'accounts/transactionsonpdf',
			'/banking/accounts/transaction/ondoc/<id:[\w-]+>' => 'accounts/transactionsondoc',
			'/banking/accounts/transaction/oncsv/<id:[\w-]+>' => 'accounts/transactionsoncsv',
			'/banking/accounts/transaction/getpdf/<md5>' => 'accounts/getpdf',
			'/banking/accounts/transaction/updatecategory/<id:[\w-]+>' => 'accounts/updatecategory',
            '/banking/personal' => 'personal/index',
            '/banking/personal/saveemails' => 'personal/saveemails',
            '/banking/personal/editemails' => 'personal/editemails',
            '/banking/personal/savephones' => 'personal/savephones',
            '/banking/personal/editphones' => 'personal/editphones',
			'/banking/personal/testsms' => 'personal/testsms',
            '/banking/personal/saveaddress' => 'personal/saveaddress',
            '/banking/personal/editaddress' => 'personal/editaddress',
            '/banking/personal/alerts' => 'personal/alerts',
            '/banking/personal/updatealerts/<id:\d+|new>' => 'personal/updatealerts',
            '/banking/personal/dropalerts/<id:\d+>' => 'personal/dropalerts',
            '/banking/personal/activate/<type:(email|address|phone)>/<hash:\w+>' => 'personal/activate',

            '/message/save/<type:(save|send|edit|socials)>/<id:\d+>' => 'message/save',
            //'/message/reply/<dialog:\d+>/<id:\d+>' => 'message/reply',
            '/message/view/<id:\d+>' => 'message/view',
            '/message/cancel/<id:\d+>' => 'message/cancel',
            '/message/new/<id:\d+>' => 'message/new',

            '/banking/verification/notary' => 'verification/notary',
            '/banking/verification/getnotaryfile' => 'verification/getnotaryfile',
            '/banking/accountsactivation' => '/banking/accountsactivation',
			'/banking/personal/uploadfile' => 'personal/uploadfile',
			'/banking/personal/emailconfirm' => 'personal/emailconfirm',
			'/banking/personal/makeprimary/<type:(emails)>/<id:\d+>' => 'personal/makeprimary',
            '/banking/personal/activate/<type:(emails|address|phones)>/<hash:\w+>' => 'personal/activate',
			'/transfers/smsconfirm/<type:(all)>' => 'transfers/smsconfirm',
			'/transfers/smsconfirm/' => 'transfers/smsconfirm',
            '/message/save/<type:(save|send)>/<id:\d+>' => 'message/save',
            '/message/cancel/<id:\d+>' => 'message/cancel',
			'/banking/verification/<modelId:(bankaccount|creditcard|paypal)>' => '/verification/verificatinmethod',
			'/banking/verification/uploadfile' => 'verification/uploadfile',
			'/account/' => 'site/registration',
			'/login' => '/site/login',
			'page/<url>' => 'pages/index',
            
            /**
             * RBAC
             */
            '/settings/roles' => 'rbac/roles',
            '/settings/roles/add' => 'rbac/addRole',
            '/settings/users/add' => 'rbac/addUser',

			'<action:(login|logout)>' => 'site/<action>',
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

        ),
    ),
    'request' => array(
        'class' => 'QHttpRequest',
		'enableCsrfValidation' => true,
		'noCsrfValidationRoutes'=>array(
			'banking/uploadactivationfile',
			'banking/accountsactivation',
			'banking/verification/uploadfile',
			'verification/notary',
			'banking/personal/uploadfile',
			'personal/uploadfile',
			'personal/editname',
			'banking/personal/uploadfile',
			'accounts/uploadattachemnt',
			'banking/accounts/transaction/uploadattachemnt/*'
		),
    ),
    'errorHandler' => array(
        // use 'site/error' action to display errors
        'errorAction' => 'site/error',
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