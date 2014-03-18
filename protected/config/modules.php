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
			'91.187.1.209',
            '::1',
            '127.0.0.1'),
    ),
    'api' => array(
        'keys' => array(
            'devel' 		=> '86.57.245.247',
            'test3migomby' 	=> '178.172.181.139',
            'migom' 		=> '178.172.181.139',
            'test' 			=> '127.0.0.1',
			'testmigomby' 	=> '93.125.53.103',
			'migomby' 		=> '93.125.53.103',
			'devmigomby' 	=> '178.172.181.139',
			'test2migomby' 	=> '93.125.53.104',
			'yamamigomby'	=> '93.125.53.104',
        )
    ),
    'admin',
	'messages',
	'catalog',
);
?>
