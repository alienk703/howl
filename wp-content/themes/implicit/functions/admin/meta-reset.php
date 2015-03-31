<?php
$meta_boxes = array(
	'title' => sprintf( __( 'Reset Values', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_post_reset',
	'pages' => array( 'post', 'page' ),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'low',
	'fields' => array(	
		array(
			'name' => __( 'Warning: Permanent Deletion', IT_TEXTDOMAIN ),
			'id' => '_reset_header',
			'desc' => __( 'These settings will cause permanent deletion and you will not be able to recover IP Addresses or total counts. For advanced use only.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Delete Likes', IT_TEXTDOMAIN ),
			'id' => '_reset_likes',
			'options' => array('reset' => __( 'Delete all IP Addresses and rest like count to 0', IT_TEXTDOMAIN )),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Delete Views', IT_TEXTDOMAIN ),
			'options' => array('reset' => __( 'Delete all IP Addresses and rest view count to 0', IT_TEXTDOMAIN )),
			'id' => '_reset_views',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Delete User Ratings', IT_TEXTDOMAIN ),
			'options' => array('reset' => __( 'Delete all user ratings for each criteria and total rating (posts only)', IT_TEXTDOMAIN )),
			'id' => '_reset_user_ratings',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Delete User Reactions', IT_TEXTDOMAIN ),
			'options' => array('reset' => __( 'Delete all user reactions for this post (posts only)', IT_TEXTDOMAIN )),
			'id' => '_reset_user_reactions',
			'type' => 'checkbox'
		),
	)
);

return array(
	'load' => true,
	'options' => $meta_boxes
);

?>
