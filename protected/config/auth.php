<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
	'client' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'individual',
        'bizRule' => null,
        'data' => null
    ),
    'individual' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'individual',
		'children' => array(
            'client',
        ),
        'bizRule' => null,
        'data' => null
    ),
	'legalentity' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'legalentity',
		'children' => array(
            'client',
        ),
        'bizRule' => null,
        'data' => null
    ),
);

?>