<?php
$meta_boxes = array(
	'title' => sprintf( __( 'Badges', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_post_badges',
	'pages' => array( 'post' ),
	'callback' => '',
	'context' => 'side',
	'priority' => 'low',
	'fields' => array(
		array(
			'name' => __( 'Badges', IT_TEXTDOMAIN ),
			'id' => IT_META_BADGES,	
			'target' => 'badges',				
			'type' => 'awards_meta'
		)
	)
);

return array(
	'load' => true,
	'options' => $meta_boxes
);
?>