<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'bizRule' => null,
        'data' => null
    ),
	'author' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Author',
		'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Moderator',
		'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
		'children' => array(
            'moderator', 
			'author',
        ),
        'bizRule' => null,
        'data' => null
    ),
	'designers' => array(
		'type' => CAuthItem::TYPE_ROLE,
        'description' => 'designers',
		'children' => array(
			'user',
        ),
        'bizRule' => null,
        'data' => null
	),
	'photographer' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'photographer',
		'children' => array(
            'user', 
        ),
        'bizRule' => null,
        'data' => null
    ),
	'copywriter' => array(
		'type' => CAuthItem::TYPE_ROLE,
        'description' => 'copywriter',
		'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
	),
	'designer' => array(
		'type' => CAuthItem::TYPE_ROLE,
        'description' => 'designer',
		'children' => array(
            'designers',
        ),
        'bizRule' => null,
        'data' => null
	),
	'craftsman' => array(
		'type' => CAuthItem::TYPE_ROLE,
        'description' => 'craftsman',
		'children' => array(
            'designers',
        ),
        'bizRule' => null,
        'data' => null
	),
);

?>