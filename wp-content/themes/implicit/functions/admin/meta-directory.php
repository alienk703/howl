<?php
$meta_boxes = array(
	'title' => sprintf( __( 'Directory Options', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_page_directory',
	'pages' => array( 'page' ),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(	
		array(
			'name' => __( 'Included Categories', IT_TEXTDOMAIN ),
			'desc' => __( 'You can choose certain categories to include in this directory page.', IT_TEXTDOMAIN ),
			'id' => '_directory_categories',
			'target' => 'cat',
			'type' => 'multidropdown',
			'shortcode_multiply' => true
		),
		array(
			'name' => __( 'List Type', IT_TEXTDOMAIN ),
			'id' => '_directory_type',
			'options' => array( 
				'merged' => __( 'Merged into one list', IT_TEXTDOMAIN ),
				'separated' => __( 'Separated into multiple lists', IT_TEXTDOMAIN ),
			),
			'default' => 'merged',
			'type' => 'radio'
		),		
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'id' => '_directory_layout',
			'options' => array( 
				'widget_a' => THEME_ADMIN_ASSETS_URI . '/images/post_layout_a.png',
				'widget_b' => THEME_ADMIN_ASSETS_URI . '/images/post_layout_b.png',
				'widget_c' => THEME_ADMIN_ASSETS_URI . '/images/post_layout_c.png',
				'widget_d' => THEME_ADMIN_ASSETS_URI . '/images/post_layout_d.png',
			),
			'default' => 'widget_a',
			'type' => 'layout'
		),	
		array(
			'name' => __( 'Disable Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'Only applies to layout A', IT_TEXTDOMAIN ),
			'id' => '_directory_ratings_disable',
			'options' => array( 'true' => __( 'Ratings will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Filters', IT_TEXTDOMAIN ),
			'id' => '_directory_filters_disable',
			'options' => array(				
				'recent' => 'Recent',
				'title' => 'Alphabetical',
				'liked' => 'Liked',
				'viewed' => 'Viewed',
				'rated' => 'User Rated',
				'reviewed' => 'Editor Reviewed',				
				'commented' => 'Commented',
				'awarded' => 'Awarded'
			),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Default Sorting', IT_TEXTDOMAIN ),
			'id' => '_directory_sort',
			'options' => array( 
				'recent' => __( 'Recent', IT_TEXTDOMAIN ),
				'title' => __( 'Alphabetical', IT_TEXTDOMAIN ),
				'liked' => __( 'Most Liked', IT_TEXTDOMAIN ),
				'viewed' => __( 'Most Viewed', IT_TEXTDOMAIN ),
				'users' => __( 'Highest User Rated', IT_TEXTDOMAIN ),
				'reviewed' => __( 'Highest Editor Reviewed', IT_TEXTDOMAIN ),
				'commented' => __( 'Most Commented', IT_TEXTDOMAIN ),
				'awarded' => __( 'Awarded', IT_TEXTDOMAIN ),
			),
			'default' => 'recent',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Reviews Only', IT_TEXTDOMAIN ),
			'id' => '_directory_reviews',
			'options' => array( 'true' => __( 'Do not include posts without ratings', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Posts Per Page', IT_TEXTDOMAIN ),
			'id' => '_directory_number',
			'target' => 'thousand',
			'nodisable' => true,
			'type' => 'select'
		),
	)
);
return array(
	'load' => true,
	'options' => $meta_boxes
);

?>
