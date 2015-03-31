<?php
$meta_boxes = array(
	'title' => sprintf( __( 'Awards', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_post_awards',
	'pages' => array( 'post' ),
	'callback' => '',
	'context' => 'side',
	'priority' => 'low',
	'fields' => array(
		array(
			'name' => __( 'Awards', IT_TEXTDOMAIN ),
			'id' => IT_META_AWARDS,	
			'target' => 'awards',				
			'type' => 'awards_meta'
		)
	)
);

return array(
	'load' => true,
	'options' => $meta_boxes
);
?>