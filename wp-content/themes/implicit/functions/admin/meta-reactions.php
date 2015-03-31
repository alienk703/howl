<?php
$meta_boxes = array(
	'title' => sprintf( __( 'Excluded Reactions', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_post_reactions',
	'pages' => array( 'post' ),
	'callback' => '',
	'context' => 'side',
	'priority' => 'low',
	'fields' => array(
		array(
			'name' => __( 'Excluded Reactions', IT_TEXTDOMAIN ),
			'id' => IT_META_REACTIONS,	
			'target' => 'reactions',				
			'type' => 'reactions_meta'
		)
	)
);

return array(
	'load' => true,
	'options' => $meta_boxes
);
?>