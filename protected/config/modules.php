<?php

return array(
    // uncomment the following to enable the Gii tool
    'gii' => array(
        'class' => 'system.gii.GiiModule',
        'password' => 'pass',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        'ipFilters' => array(
            '91.187.3.193',
			'86.57.147.222',
			'93.84.11.20',
			'91.187.24.230',
			'86.57.187.147',
            '::1',
            '127.0.0.1'
		),
    ),
    'admin',
    /*'rights'=>array(
		'superuserName'=>'SuperUser', // Name of the role with super user privileges.
		'authenticatedName'=>'Authenticated', // Name of the authenticated user role.
		'userIdColumn'=>'id', // Name of the user id column in the database.
		'userNameColumn'=>'login', // Name of the user name column in the database.
		'enableBizRule'=>true, // Whether to enable authorization item business rules.
		'enableBizRuleData'=>false, // Whether to enable data for business rules.
		'displayDescription'=>true, // Whether to use item description instead of name.
		'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages.
		'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages.
		'baseUrl'=>'/admin/rights', // Base URL for Rights. Change if module is nested.
		'layout'=>'rights.views.layouts.main', // Layout to use for displaying Rights.
		'appLayout'=>'admin.views.layouts.avant', // Application layout.
		//'cssFile'=>'rights.css', // Style sheet file to use for Rights.
		'install'=>false, // Whether to enable installer.
		'debug'=>false, // Whether to enable debug mode.
        'userClass' => 'Users',
	),*/
);
?>
