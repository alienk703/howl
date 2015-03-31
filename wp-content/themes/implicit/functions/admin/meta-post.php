<?php
$contents_menu = it_get_setting('contents_menu');
$contents_label = $contents_menu=='optin' ? __('Show contents menu for this post',IT_TEXTDOMAIN) : __('Hide contents menu for this post',IT_TEXTDOMAIN);
$meta_boxes = array(
	'title' => sprintf( __( 'Layout Options', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_post_meta_box',
	'pages' => array( 'post' ),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(		
		array(
			'name' => __( 'Post Layout', IT_TEXTDOMAIN ),
			'id' => '_post_layout',
			'options' => array(
				'classic' => THEME_ADMIN_ASSETS_URI . '/images/layout_classic.png',
				'billboard' => THEME_ADMIN_ASSETS_URI . '/images/layout_billboard.png',
				'longform' => THEME_ADMIN_ASSETS_URI . '/images/layout_longform.png',
			),
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Sidebar', IT_TEXTDOMAIN ),
			'id' => '_sidebar_disable',
			'options' => array( 'true' => __( 'Do not display a sidebar for this post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Display Sidebar', IT_TEXTDOMAIN ),
			'id' => '_sidebar_display',
			'desc' => __( 'Useful if you have disabled the sidebar site-wide but want one just for this post. Leave blank to use setting from theme options.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Force display a sidebar for this post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable View Count', IT_TEXTDOMAIN ),
			'id' => '_view_count_disable',
			'options' => array( 'true' => __( 'Do not display the view count at the top of this post.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Like Count', IT_TEXTDOMAIN ),
			'id' => '_like_count_disable',
			'options' => array( 'true' => __( 'Do not display the like button/count at the top of this post.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Sharing', IT_TEXTDOMAIN ),
			'id' => '_sharing_disable',
			'options' => array( 'true' => __( 'Do not display the sharing controls for this post.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'You can set the featured image size for this specific page', IT_TEXTDOMAIN ),
			'id' => '_featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'1200' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'type' => 'layout'
		),
		array(
			'name' => __( 'Custom Sidebar', IT_TEXTDOMAIN ),
			'desc' => __( "Select the custom sidebar that you'd like to be displayed on this page.<br /><br />Note:  You will need to first create a custom sidebar under the &quot;Sidebar&quot; tab in your theme's option panel before it will show up here.", IT_TEXTDOMAIN ),
			'id' => '_custom_sidebar',
			'target' => 'custom_sidebars',
			'type' => 'select'
		),
		array(
			'name' => __( 'Featured Video', IT_TEXTDOMAIN ),
			'desc' => __( 'You can paste a URL of a video here to display within your post. Examples on how to format the links: YouTube - http://www.youtube.com/watch?v=fxs970FMYIo. Vimeo - http://vimeo.com/8736190', IT_TEXTDOMAIN ),
			'id' => '_featured_video',
			'type' => 'text'
		),
		/*
		array(
			'name' => __( 'Background Color', IT_TEXTDOMAIN ),
			'desc' => __( 'Use a specific background color for this page', IT_TEXTDOMAIN ),
			'id' => '_bg_color',
			'default' => '000000',
			'type' => 'color'
		),		
		array(
			'name' => __( 'Override Site Background', IT_TEXTDOMAIN ),
			'desc' => __( 'This is useful if you have an image as your main site background but you want this color to show instead for this page', IT_TEXTDOMAIN ),
			'id' => '_bg_color_override',
			'options' => array( 'true' => __( 'Display this color instead of your main site background image', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Background Image', IT_TEXTDOMAIN ),
			'desc' => __( 'Use an image for the background of this specific page', IT_TEXTDOMAIN ),
			'id' => '_bg_image',
			'type' => 'upload'
		),	
		array(
			'name' => __( 'Background Position', IT_TEXTDOMAIN ),
			'id' => '_bg_position',
			'options' => array( 
				'' => __( 'Not Set (use value from theme options)', IT_TEXTDOMAIN),
				'left' => __( 'Left', IT_TEXTDOMAIN ),
				'center' => __( 'Center', IT_TEXTDOMAIN ),
				'right' => __( 'Right', IT_TEXTDOMAIN )
			),
			'default' => '',
			'type' => 'radio'
		),		
		array(
			'name' => __( 'Background Repeat', IT_TEXTDOMAIN ),
			'id' => '_bg_repeat',
			'options' => array( 
				'' => __( 'Not Set (use value from theme options)', IT_TEXTDOMAIN),
				'no-repeat' => __( 'No Repeat', IT_TEXTDOMAIN ),
				'repeat' => __( 'Tile', IT_TEXTDOMAIN ),
				'repeat-x' => __( 'Tile Horizontally', IT_TEXTDOMAIN ),
				'repeat-y' => __( 'Tile Vertically', IT_TEXTDOMAIN )
			),
			'default' => '',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Background Attachment', IT_TEXTDOMAIN ),
			'id' => '_bg_attachment',
			'options' => array( 
				'' => __( 'Not Set (use value from theme options)', IT_TEXTDOMAIN),
				'scroll' => __( 'Scroll', IT_TEXTDOMAIN ),
				'fixed' => __( 'Fixed', IT_TEXTDOMAIN )
			),
			'default' => '',
			'type' => 'radio'
		),
		*/
		array(
			'name' => __( 'Subtitle', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a subtitle for this post which will display under the title.', IT_TEXTDOMAIN ),
			'id' => '_subtitle',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Contents Menu', IT_TEXTDOMAIN ),
			'id' => '_contents_menu',
			'options' => array( 'true' => $contents_label ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Content Title', IT_TEXTDOMAIN ),
			'desc' => __( 'Useful if you are using reviews and you want to display a header above the review content.', IT_TEXTDOMAIN ),
			'id' => '_article_title',
			'type' => 'text'
		),
		array(
			'name' => __( 'Affiliate Code', IT_TEXTDOMAIN ),
			'desc' => __( 'Copy and paste in your affiliate code here. Adjust where you want it to display on the page via the Theme Options.', IT_TEXTDOMAIN ),
			'id' => IT_META_AFFILIATE_CODE,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Primary Category', IT_TEXTDOMAIN ),
			'desc' => __( 'The category that will be displayed if this post is assigned multiple categories. Leave this blank to display first alphabetical category.', IT_TEXTDOMAIN ),
			'id' => '_primary_category',
			'target' => 'cat',
			'type' => 'select'
		),
	)
);
return array(
	'load' => true,
	'options' => $meta_boxes
);

?>
