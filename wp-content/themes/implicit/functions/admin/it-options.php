<?php
$option_tabs = array(
	'it_generalsettings_tab' => array(__( 'General Settings', IT_TEXTDOMAIN ), 'tools'),
	'it_menus_tab' => array(__( 'Sticky Nav', IT_TEXTDOMAIN ), 'list'),
	'it_style_tab' => array(__( 'Style', IT_TEXTDOMAIN ), 'style'),
	'it_pages_tab' => array(__( 'Page Builders', IT_TEXTDOMAIN ), 'builder'),		
	'it_posts_tab' => array(__( 'Template Setup', IT_TEXTDOMAIN ), 'settings'),
	'it_reviews_tab' => array(__( 'Reviews', IT_TEXTDOMAIN ), 'star'),
	'it_categories_tab' => array(__( 'Categories', IT_TEXTDOMAIN ), 'folder-open'),
	'it_awards_tab' => array(__( 'Awards and Badges', IT_TEXTDOMAIN ), 'awarded'),
	'it_reactions_tab' => array(__( 'Reactions', IT_TEXTDOMAIN ), 'emo-happy'),
	'it_sidebar_tab' => array(__( 'Custom Sidebars', IT_TEXTDOMAIN ), 'sidebar'),
	'it_signoff_tab' => array(__( 'Signoffs', IT_TEXTDOMAIN ), 'signoff'),
	'it_advertising_tab' => array(__( 'Advertising', IT_TEXTDOMAIN ), 'dollar'),
	'it_footer_tab' => array(__( 'Footer', IT_TEXTDOMAIN ), 'footer'),
	'it_sociable_tab' => array(__( 'Social', IT_TEXTDOMAIN ), 'twitter'),
	'it_advanced_tab' => array(__( 'Advanced', IT_TEXTDOMAIN ), 'cog-alt')
);

#add woocommerce tab
if(function_exists('is_woocommerce')) {
	$option_tabs['it_woocommerce_tab'] = array(__( 'WooCommerce', IT_TEXTDOMAIN), 'tag' );
}

#add buddypress tab
if(function_exists('bp_current_component') || function_exists('is_bbpress')) {
	$option_tabs['it_buddypress_tab'] = array(__( 'BuddyPress/bbPress', IT_TEXTDOMAIN), 'users' );
}

$options = array(
	
	/**
	 * Navigation
	 */
	array(
		'name' => $option_tabs,
		'type' => 'navigation'
	),
	
	/**
	 * General Settings
	 */
	array(
		'name' => array( 'it_generalsettings_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Logos & Branding', IT_TEXTDOMAIN ),
			'desc' => __( 'General settings for logos and branding of your site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		
		array(
			'name' => __( 'Logo Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'You can choose whether you wish to display a custom logo or your site title.', IT_TEXTDOMAIN ),
			'id' => 'display_logo',
			'options' => array(
				'true' => __( 'Custom Image Logo', IT_TEXTDOMAIN ),
				'' => __( 'Display Site Title', IT_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		array(
			'name' => __( 'Hide Tagline', IT_TEXTDOMAIN ),
			'desc' => __( 'This disables the tagline (site description) from displaying without requiring you to actually delete the Tagline from Settings >> General (good for SEO purposes).', IT_TEXTDOMAIN ),
			'id' => 'description_disable',
			'options' => array( 'true' => __( 'Hide the site Tagline from the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo. If you are displaying your logo in the sticky bar, max height is 60px.', IT_TEXTDOMAIN ),
			'id' => 'logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Logo Width (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_width',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_height',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'HD Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo for retina displays. If you are displaying your logo in the sticky bar, max height is 120px.', IT_TEXTDOMAIN ),
			'id' => 'logo_url_hd',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Mobile Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'You can optionally specify a mobile logo to be used when the browser window is less than 440px wide.', IT_TEXTDOMAIN ),
			'id' => 'logo_mobile_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Mobile Logo Width (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_mobile_width',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_mobile_height',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Mobile HD Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo for retina displays. If you are displaying your logo in the sticky bar, max height is 120px.', IT_TEXTDOMAIN ),
			'id' => 'logo_mobile_url_hd',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Login Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo for login page.', IT_TEXTDOMAIN ),
			'id' => 'login_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Custom Favicon', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your favicon.', IT_TEXTDOMAIN ),
			'id' => 'favicon_url',
			'type' => 'upload'
		), 
		
		array(
			'name' => __( 'Sticky Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'The fixed bar containing the logo at the top of the site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'sticky_disable_global',
			'options' => array( 'true' => __( 'Hide the entire sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Search', IT_TEXTDOMAIN ),
			'id' => 'search_disable',
			'options' => array( 'true' => __( 'Disable the search box in the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Logo', IT_TEXTDOMAIN ),
			'id' => 'logo_disable_global',
			'options' => array( 'true' => __( 'Do not display the logo in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Account Controls', IT_TEXTDOMAIN ),
			'id' => 'sticky_account_disable',
			'options' => array( 'true' => __( 'Disable the account controls (login/register) from the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Use WP Login Screen', IT_TEXTDOMAIN ),
			'id' => 'sticky_force_wp_login',
			'options' => array( 'true' => __( 'Clicking the login button should take the user to the standard WordPress login page', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Badges', IT_TEXTDOMAIN ),
			'id' => 'sticky_social_disable',
			'options' => array( 'true' => __( 'Disable the social badges in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Back To Top', IT_TEXTDOMAIN ),
			'id' => 'sticky_backtotop_disable',
			'options' => array( 'true' => __( 'Disable the back to top arrow that appears when the user scrolls down.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Un-stick', IT_TEXTDOMAIN ),
			'id' => 'sticky_unstick',
			'options' => array( 'true' => __( 'Do not fix the sticky bar to the top of the site (let it scroll away).', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		
		array(
			'name' => __( 'More Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings pertain to elements that are available/visible across your entire site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),				
		array(
			'name' => __( 'Disable Comments Globally', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally disables comments from displaying, even if you have it turned on in other areas of the theme.', IT_TEXTDOMAIN ),
			'id' => 'comments_disable_global',
			'options' => array( 'true' => __( 'Completely disable the comments for the entire site', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable User E-mail Links', IT_TEXTDOMAIN ),
			'desc' => __( 'The author info at the bottom of posts as well as the author archive listing pages list social profile links for the user, including a link showing email address of the user. Use this setting to disable the user email addresses from displaying in this list of links.', IT_TEXTDOMAIN ),
			'id' => 'email_link_disable',
			'options' => array( 'true' => __( "Disable users' email address link from list of social links", IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Google Analytics Code', IT_TEXTDOMAIN ),
			'desc' =>  __( 'After signing up with Google Analytics paste the code that it gives you here.', IT_TEXTDOMAIN ),
			'id' => 'analytics_code',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS', IT_TEXTDOMAIN ),
			'desc' => __( 'This is a great place for doing quick custom styles.  For example if you wanted to change the site title color then you would paste this:', IT_TEXTDOMAIN ) . '<br /><br /><code>#logo a { color: blue; }</code>',
			'id' => 'custom_css',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Large', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to large viewports (1200px +)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_lg',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Medium', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to medium viewports (992px to 1199px)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_md_only',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Small', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to small viewports (768px to 991px)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_sm_only',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Tiny', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will only be applied to tiny viewports (767px -)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_xs',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Medium And Down', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will be applied to medium, small, and tiny viewports (1199px -)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_md',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS Small And Down', IT_TEXTDOMAIN ),
			'desc' => __( 'Style entered into this box will be applied to small and tiny viewports (991px -)', IT_TEXTDOMAIN ),
			'id' => 'custom_css_sm',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom JavaScript', IT_TEXTDOMAIN ),
			'desc' => __( 'In case you need to add some custom javascript you may insert it here.', IT_TEXTDOMAIN ),
			'id' => 'custom_js',
			'type' => 'textarea'
		),			
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sticky Nav
	 */
	array(
		'name' => array( 'it_menus_tab' => $option_tabs ),
		'type' => 'tab_start'
	),	
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'nav_disable',
			'options' => array( 'true' => __( 'Disable the sticky nav panel completely.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Hidden', IT_TEXTDOMAIN ),
			'id' => 'nav_hidden',
			'options' => array( 'true' => __( 'Require toggle click to display.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'New Articles', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings pertain to the New button at the top of the sticky nav that displays new articles.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'new_articles_disable',
			'options' => array( 'true' => __( 'Disable the new articles panel from displaying on the front page.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Prefix', IT_TEXTDOMAIN ),
			'desc' => __( 'The prefix to display before the time period in the tooltip. Leave blank to only display the time period.', IT_TEXTDOMAIN ),
			'id' => 'new_prefix',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Label Override', IT_TEXTDOMAIN ),
			'desc' => __( 'Roll your own label instead of letting the system generate one - displays in the hover tooltip.', IT_TEXTDOMAIN ),
			'id' => 'new_label_override',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Time Period', IT_TEXTDOMAIN ),
			'desc' => __( 'Show count and posts for only this time period.', IT_TEXTDOMAIN ),
			'id' => 'new_timeperiod',
			'target' => 'new_timeperiod',
			'nodisable' => true,
			'type' => 'select'
		),	
		array(
			'name' => __( 'Max Number of Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'Limits the total number of new articles displayed.', IT_TEXTDOMAIN ),
			'id' => 'new_number',
			'target' => 'new_number',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Sections', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings pertain to the "Our Sections" menu with mega menu capabilities.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Menu Type', IT_TEXTDOMAIN ),
			'id' => 'section_menu_type',
			'desc' => __( 'Choosing Mega menu style will enable latest posts from each category or tag to display directly in the menu on mouse hover.', IT_TEXTDOMAIN ),
			'options' => array( 
				'standard' => __( 'Standard menu', IT_TEXTDOMAIN ),
				'mega' => __( 'Mega menu', IT_TEXTDOMAIN ),
				'none' => __( 'Disable', IT_TEXTDOMAIN )
			),
			'default' => 'mega',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Pre-load Mega Menus', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_preload',
			'desc' => __( 'Adds a small amount of initial overhead so users do not have to wait to see posts when hovering over mega menu items. The expense is negligible in most cases.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Mega menu drop downs should populate on page load', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Icons', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_icons_disable',
			'options' => array( 'true' => __( 'Do not display icons in the section menu', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Use White Icons', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_icons_white',
			'options' => array( 'true' => __( 'Use the white version of the category icons if available', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays above the section menu. Defaults to "Our Sections".', IT_TEXTDOMAIN ),
			'id' => 'section_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Disable Label', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_label_disable',
			'options' => array( 'true' => __( 'Do not display the label above the section menu.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Max Number of Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'Limits the total number of articles displayed within the mega menus.', IT_TEXTDOMAIN ),
			'id' => 'section_menu_article_num',
			'target' => 'range_number',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'More Settings', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),			
		array(
			'name' => __( 'Secondary Menu Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays above the secondary menu. Defaults to "Navigation".', IT_TEXTDOMAIN ),
			'id' => 'secondary_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Disable Secondary Menu Label', IT_TEXTDOMAIN ),			
			'id' => 'secondary_menu_label_disable',
			'options' => array( 'true' => __( 'Do not display the label above the secondary menu.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Secondary Menu Position', IT_TEXTDOMAIN ),
			'id' => 'secondary_menu_position',
			'options' => array( 
				'after' => __( 'Below the Section menu', IT_TEXTDOMAIN ),
				'before' => __( 'Above the Section menu', IT_TEXTDOMAIN ),
				'none' => __( 'Disable', IT_TEXTDOMAIN )
			),
			'default' => 'after',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Disable Get In Touch', IT_TEXTDOMAIN ),			
			'id' => 'nav_widgets_disable',
			'options' => array( 'true' => __( 'Do not display the Get In Touch section.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Get In Touch Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays above the "Get In Touch" section. Defaults to "Get In Touch".', IT_TEXTDOMAIN ),
			'id' => 'nav_widgets_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Get In Touch Label', IT_TEXTDOMAIN ),			
			'id' => 'nav_widgets_label_disable',
			'options' => array( 'true' => __( 'Do not display the label above the Get In Touch section.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Get In Touch Email', IT_TEXTDOMAIN ),			
			'id' => 'nav_widgets_email_disable',
			'options' => array( 'true' => __( 'Do not display the email subscribe form in the Get In Touch section.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Counts', IT_TEXTDOMAIN ),			
			'id' => 'nav_widgets_counts_disable',
			'options' => array( 'true' => __( 'Do not display the Social Counts at all.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Count', IT_TEXTDOMAIN ),			
			'id' => 'social_counts_disable',
			'options' => array(
				'twitter' => __('Twitter',IT_TEXTDOMAIN),
				'facebook' => __('Facebook',IT_TEXTDOMAIN),
				'gplus' => __('Google+',IT_TEXTDOMAIN),
				'youtube' => __('Youtube',IT_TEXTDOMAIN),
				#'pinterest' => __('Pinterest',IT_TEXTDOMAIN)
			),
			'type' => 'checkbox'
		),	
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Styles
	 */
	array(
		'name' => array( 'it_style_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Accents', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for links, titles, buttons, and other accent colors.', IT_TEXTDOMAIN ),
			'id' => 'color_accent',
			'default' => '2A53C1',
			'type' => 'color'
		),	
		array(
			'name' => __( 'Sticky Bar Background', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_bar_bg',
			'default' => 'FEFFFF',
			'type' => 'color'
		),
		array(
			'name' => __( 'Sticky Bar Border', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_bar_border',
			'default' => 'DBDBDB',
			'type' => 'color'
		),
		array(
			'name' => __( 'Sticky Bar Icons', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_bar_icons',
			'default' => 'CBD2D9',
			'type' => 'color'
		),
		array(
			'name' => __( 'Sticky Bar Text', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_bar_text',
			'default' => '333333',
			'type' => 'color'
		),
		array(
			'name' => __( 'Sticky Nav Background', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_nav_bg',
			'default' => 'FEFFFF',
			'type' => 'color'
		),
		array(
			'name' => __( 'Sticky Nav Border', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_nav_border',
			'default' => 'DBDBDB',
			'type' => 'color'
		),
		array(
			'name' => __( 'Sticky Nav Icons', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_nav_icons',
			'default' => 'CBD2D9',
			'type' => 'color'
		),
		array(
			'name' => __( 'Sticky Nav Text', IT_TEXTDOMAIN ),
			'id' => 'color_sticky_nav_text',
			'default' => '333333',
			'type' => 'color'
		),
		array(
			'name' => __( 'Secondary Backgrounds', IT_TEXTDOMAIN ),
			'desc' => __( 'Content areas that are set apart from the main site background, such as post navigation, author info box, comment rating criteria panel, etc. The main site navigation is administered in the Appearance >> Background screen.', IT_TEXTDOMAIN ),
			'id' => 'color_secondary_bg',
			'default' => 'F5F6FA',
			'type' => 'color'
		),
		array(
			'name' => __( 'Borders', IT_TEXTDOMAIN ),
			'desc' => __( 'Various divider lines and content area borders.', IT_TEXTDOMAIN ),
			'id' => 'color_borders',
			'default' => 'E9E9E9',
			'type' => 'color'
		),
		array(
			'name' => __( 'Heading Text', IT_TEXTDOMAIN ),
			'desc' => __( 'Applies to all headings that appear on top of standard or secondary backgrounds (for instance, does not apply to billboard heading or any post image overlay text).', IT_TEXTDOMAIN ),
			'id' => 'color_heading_text',
			'default' => '616465',
			'type' => 'color'
		),
		array(
			'name' => __( 'Content Text (Light)', IT_TEXTDOMAIN ),
			'desc' => __( 'Used whenever lighter text is required, such as labels, subtitles, authors/dates, tags, etc.', IT_TEXTDOMAIN ),
			'id' => 'color_content_light',
			'default' => '8C8D94',
			'type' => 'color'
		),
		array(
			'name' => __( 'Content Text (Dark)', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for the main post and page content text, as well as other areas that require a darker text color, such as widget content, links, rating numbers, etc.', IT_TEXTDOMAIN ),
			'id' => 'color_content_dark',
			'default' => '333333',
			'type' => 'color'
		),
		array(
			'name' => __( 'Icons', IT_TEXTDOMAIN ),
			'desc' => __( 'Icons used in labels, headers, and sort filters.', IT_TEXTDOMAIN ),
			'id' => 'color_icons',
			'default' => 'BFC5CC',
			'type' => 'color'
		),
		array(
			'name' => __( 'Hover Opacity', IT_TEXTDOMAIN ),
			'desc' => __( 'When hovering over post panels the category or accent color displays. This is how you set the level of opacity (or "darkness") of the color overlay. Higher number means more opaque (less transparent). Default is 80.', IT_TEXTDOMAIN ),
			'id' => 'hover_opacity',
			'target' => 'range_number',
			'type' => 'select',
			'nodisable' => true,
		),	
		array(
			'name' => __( 'Main Background Color', IT_TEXTDOMAIN ),
			'desc' => __( 'Set this in Appearance >> Background. Please note: because this theme is full-width there will never be a time when a background image can be used.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Category Colors', IT_TEXTDOMAIN ),
			'desc' => __( 'Setup unique colors for each of your categories in the Categories tab on the left.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Fonts', IT_TEXTDOMAIN ),
			'desc' => __( 'You can override the default fonts for several parts of the theme by selecting them below. Leave the font unselected to use the default font, or if you have already made a selection and want to set it back to the default, select "Choose One..." For performance reasons only selected fonts will be imported from Google, which means we cannot display all the actual font faces in this list. To preview what each font looks like without having to activate each one, go to Google Fonts and take a look: http://www.google.com/fonts/', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Label Style A', IT_TEXTDOMAIN ),
			'desc' => __( 'Labels and headers that use the "Lato" font face by default, such as menu headers and rating criteria labels.', IT_TEXTDOMAIN ),
			'id' => 'font_labels_a',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Label Style B', IT_TEXTDOMAIN ),
			'desc' => __( 'Labels and headers that use the "Playfair Display" font face by default, such as page builder titles and widget headers.', IT_TEXTDOMAIN ),
			'id' => 'font_labels_b',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Wide Loop Titles', IT_TEXTDOMAIN ),
			'desc' => __( 'Post titles for all blog loop layouts and the wide posts within grid layouts', IT_TEXTDOMAIN ),
			'id' => 'font_overlays_a',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Normal Loop Titles', IT_TEXTDOMAIN ),
			'desc' => __( 'Post titles for normal (non-wide) posts within grid layouts', IT_TEXTDOMAIN ),
			'id' => 'font_overlays_b',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Menus', IT_TEXTDOMAIN ),
			'desc' => __( 'Sticky nav, utility menu, contents menu, and recommended sorting links.', IT_TEXTDOMAIN ),
			'id' => 'font_menus',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Main Content A', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for most of the content that appears on single posts and pages, including the main post body for classic and billboard style posts.', IT_TEXTDOMAIN ),
			'id' => 'font_main_a',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Main Content B', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for the body of longform style posts as well as excerpts in blog page builders.', IT_TEXTDOMAIN ),
			'id' => 'font_main_b',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Classic Title', IT_TEXTDOMAIN ),
			'desc' => __( 'The post title used in classic style posts.', IT_TEXTDOMAIN ),
			'id' => 'font_classic',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Longform Title', IT_TEXTDOMAIN ),
			'desc' => __( 'The post title used in longform style posts.', IT_TEXTDOMAIN ),
			'id' => 'font_longform',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Content Headings A', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for h1, h2, and h3 heading sizes within single post and page content.', IT_TEXTDOMAIN ),
			'id' => 'font_headers_a',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Content Headings B', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for h4, h5, and h6 heading sizes within single post and page content.', IT_TEXTDOMAIN ),
			'id' => 'font_headers_b',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Widgets', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for a majority of widget content, except when specific fonts take priority, like post overlay titles and authorship information.', IT_TEXTDOMAIN ),
			'id' => 'font_widgets',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Numbers', IT_TEXTDOMAIN ),
			'desc' => __( 'Ratings, reactions, large social counts (widget panels), and large meta counts (longform posts).', IT_TEXTDOMAIN ),
			'id' => 'font_numbers',
			'target' => 'fonts',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Font Sizes and Subsets', IT_TEXTDOMAIN ),			
			'type' => 'heading'
		),
		
		array(
			'name' => __( 'Menus', IT_TEXTDOMAIN ),
			'id' => 'font_menus_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Main Content A', IT_TEXTDOMAIN ),
			'desc' => __( 'Classic and billboard style post content.', IT_TEXTDOMAIN ),
			'id' => 'font_content_a_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Main Content B', IT_TEXTDOMAIN ),
			'desc' => __( 'Longform style post content.', IT_TEXTDOMAIN ),
			'id' => 'font_content_b_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Add Subsets', IT_TEXTDOMAIN ),
			'desc' => __( 'Leave this unselected unless you specifically want to add subsets beyond Latin. This will only work for fonts that actually have the specific subset (refer to Google Fonts to see which ones have subsets). This also adds the character sets to the default theme fonts. Be careful! Adding subsets will impact page load times.', IT_TEXTDOMAIN ),
			'id' => 'font_subsets',
			'options' => array(
				'latin' => 'Latin',
				'latin-ext' => 'Latin Extended',
				'cyrillic' => 'Cyrillic',
				'cyrillic-ext' => 'Cyrillic Extended',
				'greek' => 'Greek',
				'greek-ext' => 'Greek Extended'
			),
			'type' => 'checkbox'
		),

	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Page Builders
	 */
	array(
		'name' => array( 'it_pages_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Front Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for your front page if Settings >> Reading >> "Front page displays" is set to "Your latest posts".', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'front_builder',
			'type' => 'builder'
		),
		
		array(
			'name' => __( 'Archive Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All category, tag, author, and date listing archive pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'archive_builder',
			'type' => 'builder'
		),	
		
		array(
			'name' => __( 'Search Results Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All pages that list search results.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'search_builder',
			'type' => 'builder'
		),		
		
		array(
			'name' => __( 'Standard Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All standard pages created in the WordPress >> Pages area (also includes 404s). You should choose "Page/Post Content" at the very minimum. You can selectively override these settings in the Layout Options for each specific page.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'page_builder',
			'type' => 'builder'
		),
		
		array(
			'name' => __( 'Single Post Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All individual posts. You should choose "Page/Post Content" at the very minimum. You can selectively override these settings in the Layout Options for each specific post.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'single_builder',
			'type' => 'builder'
		),
		
		array(
			'name' => __( 'Author Listing Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'Pages with the "Author Listing" page template assigned.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'author_builder',
			'type' => 'builder'
		),	
		
		array(
			'name' => __( 'Post Loop Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'Common settings for blog and grid post loop layouts used throughout the theme.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
			'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
			'id' => 'loop_filter_disable',
			'options' => array(
				'liked' => 'Liked',
				'viewed' => 'Viewed',
				'reviewed' => 'Reviewed',
				'rated' => 'Rated',
				'commented' => 'Commented',
				'awarded' => 'Awarded',
				'title' => 'Alphabetical'
			),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Filter Tooltips', IT_TEXTDOMAIN ),
			'id' => 'loop_tooltips_disable',
			'options' => array( 'true' => __( 'Disable the filter button tooltips', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This will disable the tooltips that display when you hover over the filter buttons', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Category Icon', IT_TEXTDOMAIN ),
			'id' => 'loop_category_disable',
			'options' => array( 'true' => __( 'The category icon will not display within the loop', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Rating', IT_TEXTDOMAIN ),
			'id' => 'loop_rating_disable',
			'options' => array( 'true' => __( 'Ratings will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Likes', IT_TEXTDOMAIN ),
			'id' => 'loop_likes_disable',
			'options' => array( 'true' => __( 'Likes will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Views', IT_TEXTDOMAIN ),
			'id' => 'loop_views_disable',
			'options' => array( 'true' => __( 'Views will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comments', IT_TEXTDOMAIN ),
			'id' => 'loop_comments_disable',
			'options' => array( 'true' => __( 'Comments will only display on single post pages', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'The number of comments will not display in the main loop. Keep in mind the comments will automatically be hidden if there are no comments for the post even if this option is unselected.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Show Featured Videos', IT_TEXTDOMAIN ),
			'id' => 'loop_video',
			'options' => array( 'true' => __( 'Show play button when a featured video is detected', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'When the post has a featured video assigned, display the play button in the image overlay which opens the featured video in a colorbox overlay panel.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Show Video Controls', IT_TEXTDOMAIN ),
			'id' => 'loop_video_controls',
			'options' => array( 'true' => __( 'Show video controls for featured videos (youtube only)', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'When a featured video is shown in the colorbox overlay panel, display the controls at the bottom of the video (only applies to Youtube videos).', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),			
		array(
			'name' => __( 'Excerpt Length', IT_TEXTDOMAIN ),
			'desc' => __( 'Leave blank for default excerpt lengths. Or, specify your desired excerpt length in characters (not words). For reference, the default is 1500 characters. Applies only to blog layout loops.', IT_TEXTDOMAIN ),
			'id' => 'loop_excerpt_length',
			'type' => 'text'
		),	
		array(
			'name' => __( 'Pagination', IT_TEXTDOMAIN ),
			'desc' => __( 'The page number buttons and navigation that appear below the post loop.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Range', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of pages to display to the right and left of the current page. Setting this to 3 for example will result in 7 total possible page number buttons generated (3 on the left, 3 on the right, plus the current page) in addition to the arrow navigation (if enabled).', IT_TEXTDOMAIN ),
			'id' => 'page_range',
			'target' => 'range_number',
			'type' => 'select',
			'nodisable' => true,
		),	
		array(
			'name' => __( 'Range (Mobile)', IT_TEXTDOMAIN ),
			'desc' => __( 'You can set a different range for mobile views so that the pagination fits into one row. If you want the pagination to fit into one row set this to 2.', IT_TEXTDOMAIN ),
			'id' => 'page_range_mobile',
			'target' => 'range_number',
			'type' => 'select',
			'nodisable' => true,
		),	
		array(
			'name' => __( 'Disable Prev/Next Navigation', IT_TEXTDOMAIN ),
			'id' => 'prev_next_disable',
			'options' => array( 'true' => __( 'Hide the next and previous navigation arrows.', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'These arrows display on the right and left of the pagination. They do not navigate to the next and previous pages, but rather the next and previous blocks of page numbers. For instance, if the range is set to 6 the next arrow will increase the current page 8 slots (range + current page + 1).', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable First/Last Navigation', IT_TEXTDOMAIN ),
			'id' => 'first_last_disable',
			'options' => array( 'true' => __( 'Hide the first and last navigation arrows.', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'These arrows display on the right and left of the pagination and they are used for quickly navigating to the first or last page.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( '"Connect" Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'The bar that displays the email signup, social counts, and social badges', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Disable Email Signup', IT_TEXTDOMAIN ),
			'id' => 'connect_email_disable',
			'options' => array( 'true' => __( 'Disable the email signup form right of the main label', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Email label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the placeholder text that displays in the email singup textbox.', IT_TEXTDOMAIN ),
			'id' => 'email_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Social Counts', IT_TEXTDOMAIN ),
			'id' => 'connect_counts_disable',
			'options' => array( 'true' => __( 'Disable the social counts right of the email singup', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Badges', IT_TEXTDOMAIN ),
			'id' => 'connect_social_disable',
			'options' => array( 'true' => __( 'Disable the social badges at the very right of the connect bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		

	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Template Options
	 */
	array(
		'name' => array( 'it_posts_tab' => $option_tabs ),
		'type' => 'tab_start'
	),	
		
		array(
			'name' => __( 'Archives', IT_TEXTDOMAIN ),
			'desc' => __( 'Adjustment options for category/tag/date/search listing pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Ignore Excludes/Limits', IT_TEXTDOMAIN ),
			'desc' => __( 'This applies to the Paged Grid, Infinite Grid, Paged Blog, and Infinite Blog builder panels. If you have selected any categories or tags in any of the excluded or limited drop downs and you do not want those settings to apply to your archive listing pages, turn on this option.', IT_TEXTDOMAIN ),
			'id' => 'archive_ignore_excludes',
			'options' => array( 'true' => __( 'Disregard any category or tag exclusions or limits for Grid/Blog panels.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
	
		array(
			'name' => __( 'Standard Pages', IT_TEXTDOMAIN ),
			'desc' => __( 'Show/hide various components for standard pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Disable Sidebar', IT_TEXTDOMAIN ),
			'id' => 'page_sidebar_disable',
			'desc' => __( 'Can be overridden per page', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Do not display a sidebar for standard pages.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Control Bar', IT_TEXTDOMAIN ),
			'id' => 'page_controlbar_disable',
			'options' => array( 'true' => __( 'Disable the entire control bar above the page title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Page Navigation', IT_TEXTDOMAIN ),
			'id' => 'page_postnav_disable',
			'options' => array( 'true' => __( 'Disable the page navigation in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable View Count', IT_TEXTDOMAIN ),
			'id' => 'page_views_disable',
			'options' => array( 'true' => __( 'Disable the view count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
			'id' => 'page_likes_disable',
			'options' => array( 'true' => __( 'Disable the like button in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Count', IT_TEXTDOMAIN ),
			'id' => 'page_comment_count_disable',
			'options' => array( 'true' => __( 'Disable the comment count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Sharing', IT_TEXTDOMAIN ),
			'id' => 'page_sharing_disable',
			'options' => array( 'true' => __( 'Disable the social sharing in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Date/Author', IT_TEXTDOMAIN ),
			'id' => 'page_authorship_disable',
			'options' => array( 'true' => __( 'Disable the page date and author below the page title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'The default featured image size for all standard pages only', IT_TEXTDOMAIN ),
			'id' => 'page_featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'1200' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'default' => '360',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Video', IT_TEXTDOMAIN ),
			'id' => 'page_video_disable',
			'options' => array( 'true' => __( 'When a page has a featured video assigned do not display it.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Enable Comments', IT_TEXTDOMAIN ),
			'id' => 'page_comments',
			'options' => array( 'true' => __( 'Enable comments on regular pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Single Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'Show/hide various components for single post views.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'id' => 'post_layout',
			'options' => array(
				'classic' => THEME_ADMIN_ASSETS_URI . '/images/layout_classic.png',
				'billboard' => THEME_ADMIN_ASSETS_URI . '/images/layout_billboard.png',
				'longform' => THEME_ADMIN_ASSETS_URI . '/images/layout_longform.png',
				),
			'default' => 'classic',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Sidebar', IT_TEXTDOMAIN ),
			'id' => 'post_sidebar_disable',
			'desc' => __( 'Can be overridden per post', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Do not display a sidebar for single posts.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Default Post Type', IT_TEXTDOMAIN ),
			'id' => 'post_type_default',
			'desc' => __( 'You can select whether a post is an Article or a Review on a post-by-post basis in the Review Options panel when editing the post. Use this option to select whether the default option should be Article or Review.', IT_TEXTDOMAIN ),
			'options' => array( 
				'true' => __( 'Article', IT_TEXTDOMAIN ),
				'false' => __( 'Review', IT_TEXTDOMAIN ),
			),
			'default' => 'true',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Disable Control Bar', IT_TEXTDOMAIN ),
			'id' => 'post_controlbar_disable',
			'options' => array( 'true' => __( 'Disable the entire control bar above the post title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Post Navigation', IT_TEXTDOMAIN ),
			'id' => 'post_postnav_disable',
			'options' => array( 'true' => __( 'Disable the post navigation in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable View Count', IT_TEXTDOMAIN ),
			'id' => 'post_views_disable',
			'options' => array( 'true' => __( 'Disable the view count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
			'id' => 'post_likes_disable',
			'options' => array( 'true' => __( 'Disable the like button in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Count', IT_TEXTDOMAIN ),
			'id' => 'post_comment_count_disable',
			'options' => array( 'true' => __( 'Disable the comment count in the control bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Sharing', IT_TEXTDOMAIN ),
			'id' => 'post_sharing_disable',
			'options' => array( 'true' => __( 'Disable the social sharing in the control bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Date/Author', IT_TEXTDOMAIN ),
			'id' => 'post_authorship_disable',
			'options' => array( 'true' => __( 'Disable the post date and author below the post title', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Author Avatar', IT_TEXTDOMAIN ),
			'id' => 'post_authorship_avatar_disable',
			'options' => array( 'true' => __( 'Disable the author avatar at the top of the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'The default featured image size for all standard posts only', IT_TEXTDOMAIN ),
			'id' => 'post_featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'1200' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'default' => '360',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Clickable Image', IT_TEXTDOMAIN ),
			'desc' => __( 'Turn this off to disable clicking on the featured image, which opens the largest size of the image in a lightbox (if the lightbox effect is not disabled) or as a new page in the browser.', IT_TEXTDOMAIN ),
			'id' => 'clickable_image_disable',
			'options' => array( 'true' => __( 'Featured image should not be clickable.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Featured Image Captions', IT_TEXTDOMAIN ),
			'id' => 'featured_image_caption',
			'options' => array( 'true' => __( 'Display caption text under featured image if any exists.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Lightbox Effect', IT_TEXTDOMAIN ),
			'id' => 'colorbox_disable',
			'options' => array( 'true' => __( 'Disable the lightbox when clicking on featured image/galleries', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Lightbox Slideshow', IT_TEXTDOMAIN ),
			'id' => 'colorbox_slideshow',
			'options' => array( 'true' => __( 'Gallery lightboxes should behave as a slideshow', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Video', IT_TEXTDOMAIN ),
			'id' => 'post_video_disable',
			'options' => array( 'true' => __( 'When a post has a featured video assigned do not display it.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Contents Menu Behavior', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the fixed, post-specific navigation menu that links to different parts of the post. If you choose opt-in you can selectively enable this menu for specific posts (otherwise it will be disabled). If you choose one of the first two options you can selectively disable it for specific posts (otherwise it will be enabled).', IT_TEXTDOMAIN ),
			'id' => 'contents_menu',
			'options' => array(
				'both' => __( 'Show on Articles and Reviews', IT_TEXTDOMAIN ),
				'reviews' => __( 'Show only on Reviews', IT_TEXTDOMAIN ),	
				'optin' => __( 'Opt-in', IT_TEXTDOMAIN ),
				'none' => __( 'Disable', IT_TEXTDOMAIN ),				
			),
			'default' => 'reviews',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Content Title', IT_TEXTDOMAIN ),
			'desc' => __( 'Useful if you are using reviews and you want to display a header above the review content.', IT_TEXTDOMAIN ),
			'id' => 'article_title',
			'type' => 'text'
		),
		array(
			'name' => __( 'Posts Content Title Disable', IT_TEXTDOMAIN ),
			'desc' => __( 'By default the content title displays on both Review and Article post types. Use this option if you want the content title to be disabled on posts with the Article post type.', IT_TEXTDOMAIN ),
			'id' => 'post_article_title_disable',
			'options' => array( 'true' => __( 'Disable the content title on standard article posts (non-review)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Reactions Position', IT_TEXTDOMAIN ),
			'id' => 'reactions_position',
			'options' => array( 
				'top' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'bottom' => __( 'Below the post content', IT_TEXTDOMAIN ),
				'none' => __( 'Disable reactions', IT_TEXTDOMAIN ),
			),
			'default' => 'bottom',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Big Like Button Position', IT_TEXTDOMAIN ),
			'desc' => __( "Users can always click the like count at the top of the post to like it. However, you can add another big noticeable like button to catch the user's eye if you prefer. *For longform style posts the like button will display in the right column at the top regardless of which of these settings you use.", IT_TEXTDOMAIN ),
			'id' => 'biglike_position',
			'options' => array( 
				'meta-bar' => __( 'Inside the top "meta" bar*', IT_TEXTDOMAIN ),
				'before-content' => __( 'Above the post content*', IT_TEXTDOMAIN ),
				'after-content' => __( 'Below the post content*', IT_TEXTDOMAIN ),
				'after-reactions' => __( 'Within the "Reactions" buttons', IT_TEXTDOMAIN ),
				'none' => __( 'Disable', IT_TEXTDOMAIN ),
			),
			'default' => 'bottom',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Affiliate Link Position', IT_TEXTDOMAIN ),
			'id' => 'affiliate_position',
			'options' => array( 
				'before-overview' => __( 'At the top of the Overview section', IT_TEXTDOMAIN ),
				'after-overview' => __( 'At the bottom of the Overview section', IT_TEXTDOMAIN ),
				'rating' => __( 'After the Rating', IT_TEXTDOMAIN ),
				'before-content' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'after-content' => __( 'Below the post content', IT_TEXTDOMAIN ),
			),
			'default' => 'bottom',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Recommended Title', IT_TEXTDOMAIN ),
			'desc' => __( 'The title text to display above the reactions buttons', IT_TEXTDOMAIN ),
			'id' => 'reactions_title',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Reactions Style', IT_TEXTDOMAIN ),
			'id' => 'reactions_style',
			'options' => array( 
				'icon' => __( 'Icon only', IT_TEXTDOMAIN ),
				'name' => __( 'Name only', IT_TEXTDOMAIN ),
				'both' => __( 'Icon + Name', IT_TEXTDOMAIN ),
			),
			'default' => 'both',
			'type' => 'radio'
		),		
		array(
			'name' => __( 'Disable Author Info', IT_TEXTDOMAIN ),
			'id' => 'post_author_disable',
			'options' => array( 'true' => __( 'Disable the author information below the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Recommended', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_disable',
			'options' => array( 'true' => __( 'Disable the recommended posts section', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Recommended Method', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_method',
			'desc' => __( 'For the "Same tags OR same categories" method, use the "Number of Recommended Filters" option below to set how many of EACH will display, rather than how many TOTAL as is applied to the rest of the methods. So setting this to "2" will cause the first two tags and the first two categories to display, resulting in four total filters.', IT_TEXTDOMAIN ),
			'options' => array( 
				'tags' => __( 'Same tags', IT_TEXTDOMAIN ),
				'categories' => __( 'Same categories', IT_TEXTDOMAIN ),
				'tags_categories' => __( 'Same tags OR same categories (tags will appear first in order)', IT_TEXTDOMAIN ),
			),
			'default' => 'tags',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Recommended Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The title text to display in the title of the recommended section', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Number of Recommended Filters', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of filter buttons to display in the recommended filter bar.', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_filters_num',
			'target' => 'recommended_filters_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Recommended Filters', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_filters_disable',
			'options' => array( 'true' => __( 'Disable the filter buttons from the recommended section', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Number of Recommended Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of total posts to display in the recommended section.', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_num',
			'target' => 'recommended_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Comments', IT_TEXTDOMAIN ),
			'id' => 'post_comments_disable',
			'options' => array( 'true' => __( 'Disable the comments (useful for Facebook comment plugins)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Author Listing', IT_TEXTDOMAIN ),
			'desc' => __( 'Adjustment options for pages with the "Author Listing" page template assigned.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Enable Admins', IT_TEXTDOMAIN ),
			'id' => 'author_admin_enable',
			'options' => array( 'true' => __( 'Allow the admin user role to display in the list', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Hide Empty', IT_TEXTDOMAIN ),
			'id' => 'author_empty_disable',
			'options' => array( 'true' => __( 'Hide authors with zero posts', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Manual Exclude', IT_TEXTDOMAIN ),
			'desc' => __( 'Enter a comma-separated list of usernames to exclude', IT_TEXTDOMAIN ),
			'id' => 'author_exclude',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'User Role', IT_TEXTDOMAIN ),
			'desc' => __( 'Select a user role to display', IT_TEXTDOMAIN ),
			'id' => 'author_role',
			'target' => 'author_role',
			'type' => 'select'
		),
		array(
			'name' => __( 'Order', IT_TEXTDOMAIN ),
			'desc' => __( 'Select how to order the list', IT_TEXTDOMAIN ),
			'id' => 'author_order',
			'target' => 'author_order',
			'type' => 'select'
		),
	
	array(
		'type' => 'tab_end'
	),

	/**
	 * Reviews
	 */
	array(
		'name' => array( 'it_reviews_tab' => $option_tabs ),
		'type' => 'tab_start'
	),

		array(
			'name' => __( 'Details', IT_TEXTDOMAIN ),
			'desc' => __( 'Details are additional descriptive data about the article that you want to list in the overview area. They are different than categories because they are not so much classification data as they are describing data. For instance, if you were writing an article on a movie, a category might be Director and a detail might be Plot Synopsis, because a director can be assigned to multiple movies but a plot synopsis is descriptive only for a single movie. You can of course choose how to use categories and Details however you want for your articles, these are just suggestions to help you understand the difference between them. It is completely up to you.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
			
		array(
			'name' => '',
			'id' => 'review_details',
			'type' => 'details'
		),	
		
		array(
			'name' => __( 'Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings dictate how you want to rate the articles, if at all.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Rating Metric', IT_TEXTDOMAIN ),
			'desc' => __( 'The type of rating metric to use', IT_TEXTDOMAIN ),
			'id' => 'review_rating_metric',
			'options' => array( 
				'stars' => __( 'Stars', IT_TEXTDOMAIN ),
				'number' => __( 'Numbers', IT_TEXTDOMAIN ),
				'percentage' => __( 'Percentages', IT_TEXTDOMAIN ),
				'letter' => __( 'Letter Grades', IT_TEXTDOMAIN )
			),
			'default' => 'stars',
			'type' => 'radio'
		),		
		array(
			'name' => __( 'Rating Criteria (automatically averaged into the total score)', IT_TEXTDOMAIN ),
			'id' => 'review_criteria',
			'type' => 'criteria'
		),			
		array(
			'name' => __( 'Disable Editor Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This will disable the editor ratings from appearing anywhere in the site.', IT_TEXTDOMAIN ),
			'id' => 'review_editor_rating_disable',
			'options' => array( 'true' => __( 'Do not use editor ratings at all', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This will disable the user rating from appearing anywhere in the site.', IT_TEXTDOMAIN ),
			'id' => 'review_user_rating_disable',
			'options' => array( 'true' => __( 'Do not use user ratings at all', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Hide Editor Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This should be used if you DO want to use editor ratings but ONLY want them to be visible on the full review page.', IT_TEXTDOMAIN ),
			'id' => 'review_editor_rating_hide',
			'options' => array( 'true' => __( 'Hides editor rating from image overlays', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Hide User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This should be used if you DO want to use user ratings but ONLY want them to be visible on the full review page.', IT_TEXTDOMAIN ),
			'id' => 'review_user_rating_hide',
			'options' => array( 'true' => __( 'Hides user rating from image overlays', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable "Top" User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This will disable th ability for users to rate articles at the top of the article and require them to use the comment system to add their comment.', IT_TEXTDOMAIN ),
			'id' => 'review_top_rating_disable',
			'options' => array( 'true' => __( 'Only allow user ratings from comments (if enabled)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Ratings Header Label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the main header that displays at the top of the ratings section.', IT_TEXTDOMAIN ),
			'id' => 'review_ratings_header',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Editor Rating Label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the header that displays at the top of the editor ratings column.', IT_TEXTDOMAIN ),
			'id' => 'review_editor_header',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'User Rating Label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the header that displays at the top of the user ratings column.', IT_TEXTDOMAIN ),
			'id' => 'review_user_header',
			'htmlentities' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Hide Number of User Ratings', IT_TEXTDOMAIN ),
			'id' => 'review_user_ratings_number_disable',
			'options' => array( 'true' => __( 'Hide number of user ratings next to the total user score label', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Registration Required', IT_TEXTDOMAIN ),
			'desc' => __( 'If you turn this on the theme will keep track of ratings based on WordPress username, otherwise it will use the IP address of the user.', IT_TEXTDOMAIN ),
			'id' => 'review_registered_user_ratings',
			'options' => array( 'true' => __( 'Anonymous users will not be able to add ratings.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'User Ratings 2.0', IT_TEXTDOMAIN ),
			'desc' => __( 'Turn this on to use the new user rating system, which allows users to edit their own ratings. CAUTION: this will cause you to lose all of your existing user ratings for all of your posts. You should reset your user reviews for each of your existing reviews to avoid conflicts.', IT_TEXTDOMAIN ),
			'id' => 'review_user_ratings_new',
			'options' => array( 'true' => __( 'Use the new method of storing user reviews (users can edit their ratings).', IT_TEXTDOMAIN ) ),
			'default' => 'true',
			'type' => 'checkbox'			
		),
		
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the way review articles display.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Details Position', IT_TEXTDOMAIN ),
			'id' => 'review_details_position',
			'options' => array( 
				'top' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'bottom' => __( 'Below the post content', IT_TEXTDOMAIN ),
				'none' => __( 'Disable details', IT_TEXTDOMAIN ),
			),
			'default' => 'top',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Ratings Position', IT_TEXTDOMAIN ),
			'id' => 'review_ratings_position',
			'options' => array( 
				'top' => __( 'Above the post content', IT_TEXTDOMAIN ),
				'bottom' => __( 'Below the post content', IT_TEXTDOMAIN ),
				'none' => __( 'Disable details', IT_TEXTDOMAIN ),
			),
			'default' => 'top',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Positives Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the title for the positives section', IT_TEXTDOMAIN ),
			'id' => 'review_positives_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Negatives Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the title for the negatives section', IT_TEXTDOMAIN ),
			'id' => 'review_negatives_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Bottom Line Label', IT_TEXTDOMAIN ),
			'desc' => __( 'Used as the title for the bottom line section', IT_TEXTDOMAIN ),
			'id' => 'review_bottomline_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Hide Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'If taxonomies, details, and badges are all hidden the entire details box will not be displayed', IT_TEXTDOMAIN ),
			'id' => 'review_badges_hide',
			'options' => array( 'true' => __( 'Hide the listing of badges in the details box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Hide Details', IT_TEXTDOMAIN ),
			'desc' => __( 'If taxonomies, details, and badges are all hidden the entire details box will not be displayed', IT_TEXTDOMAIN ),
			'id' => 'review_details_hide',
			'options' => array( 'true' => __( 'Hide the listing of details in the details box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Details Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The title text to display next to the icon in the details section', IT_TEXTDOMAIN ),
			'id' => 'review_details_label',
			'htmlentities' => true,
			'type' => 'text'
		),			
		array(
			'name' => __( 'Disable Comment Ratings', IT_TEXTDOMAIN ),
			'id' => 'review_user_comment_rating_disable',
			'options' => array( 'true' => __( 'Do not allow users to rate articles in the comments', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Pros/Cons', IT_TEXTDOMAIN ),
			'id' => 'review_user_comment_procon_disable',
			'options' => array( 'true' => __( 'Do not allow users to enter pros and cons with their comment', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Allow Blank Comments', IT_TEXTDOMAIN ),
			'desc' => __( 'Use this if you want your users to be able to submit ratings and/or pros/cons without having to additionally enter standard comment text. Only applies if user comment ratings are enabled.', IT_TEXTDOMAIN ),
			'id' => 'review_allow_blank_comments',
			'options' => array( 'true' => __( 'Allow users to post comments without actual comment text', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),

	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Categories
	 */
	array(
		'name' => array( 'it_categories_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Add attributes to your categories such as icons and colors. First you need to create the category in Posts >> Categories (or while editing posts), then it will become available to select from the drop down lists below so you can add attributes to the category.', IT_TEXTDOMAIN ),
			'id' => 'categories',
			'type' => 'categories'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Awards
	 */
	array(
		'name' => array( 'it_awards_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Create Awards and Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create as many awards and badges as you want here and they will be visible to assign to posts on the post edit screen.', IT_TEXTDOMAIN ),
			'id' => 'review_awards',
			'type' => 'awards'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Reactions
	 */
	array(
		'name' => array( 'it_reactions_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Create the various reactions that your users can interact with for articles', IT_TEXTDOMAIN ),
			'id' => 'reactions',
			'type' => 'reactions'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sidebar
	 */
	array(
		'name' => array( 'it_sidebar_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Create New Sidebar', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create additional sidebars to use. To display your new sidebar then you will need to select it in the &quot;Custom Sidebar&quot; dropdown when editing a post or page.', IT_TEXTDOMAIN ),
			'id' => 'custom_sidebars',
			'type' => 'sidebar'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Signoff
	 */
	array(
		'name' => array( 'it_signoff_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Create New Signoff', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create an unlimited number of signoff text areas and then choose the one you want to use for each post.', IT_TEXTDOMAIN ),
			'id' => 'signoff',
			'type' => 'signoff'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Advertising
	 */
	array(
		'name' => array( 'it_advertising_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'General', IT_TEXTDOMAIN ),
			'desc' => __( 'Ads that appear on every page.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Header', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays directly under the sticky bar on all pages.', IT_TEXTDOMAIN ),
			'id' => 'ad_header',
			'htmlentities' => true,
			'type' => 'textarea'
		),		
		array(
			'name' => __( 'Footer', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays directly above the footer on all pages.', IT_TEXTDOMAIN ),
			'id' => 'ad_footer',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Page Builders', IT_TEXTDOMAIN ),
			'desc' => __( 'Ads that appear between page builder panels.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),		
		array(
			'name' => __( 'Before Grid', IT_TEXTDOMAIN ),
			'id' => 'ad_grid_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Grid', IT_TEXTDOMAIN ),
			'id' => 'ad_grid_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),		
		array(
			'name' => __( 'Before Blog', IT_TEXTDOMAIN ),
			'id' => 'ad_list_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Blog', IT_TEXTDOMAIN ),
			'id' => 'ad_list_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Horizontal Scroller', IT_TEXTDOMAIN ),
			'id' => 'ad_scroller_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Horizontal Scroller', IT_TEXTDOMAIN ),
			'id' => 'ad_scroller_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Headliner', IT_TEXTDOMAIN ),
			'id' => 'ad_headliner_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Headliner', IT_TEXTDOMAIN ),
			'id' => 'ad_headliner_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Connect', IT_TEXTDOMAIN ),
			'id' => 'ad_connect_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Connect', IT_TEXTDOMAIN ),
			'id' => 'ad_connect_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Widgets', IT_TEXTDOMAIN ),
			'id' => 'ad_widgets_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Widgets', IT_TEXTDOMAIN ),
			'id' => 'ad_widgets_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Top Ten', IT_TEXTDOMAIN ),
			'id' => 'ad_topten_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Top Ten', IT_TEXTDOMAIN ),
			'id' => 'ad_topten_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Trending', IT_TEXTDOMAIN ),
			'id' => 'ad_trending_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Trending', IT_TEXTDOMAIN ),
			'id' => 'ad_trending_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Utility Menu', IT_TEXTDOMAIN ),
			'id' => 'ad_utility_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Utility Menu', IT_TEXTDOMAIN ),
			'id' => 'ad_utility_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Custom HTML', IT_TEXTDOMAIN ),
			'id' => 'ad_html_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Custom HTML', IT_TEXTDOMAIN ),
			'id' => 'ad_html_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),		
		
		array(
			'name' => __( 'Single Posts/Pages', IT_TEXTDOMAIN ),
			'desc' => __( 'Ads that appear only on single posts and pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Before Directory', IT_TEXTDOMAIN ),
			'id' => 'ad_directory_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Directory', IT_TEXTDOMAIN ),
			'id' => 'ad_directory_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Title (Longform)', IT_TEXTDOMAIN ),
			'id' => 'ad_longform_title_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Title (Longform)', IT_TEXTDOMAIN ),
			'id' => 'ad_longform_title_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Title (Billboard)', IT_TEXTDOMAIN ),
			'id' => 'ad_billboard_title_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Title (Billboard)', IT_TEXTDOMAIN ),
			'id' => 'ad_billboard_title_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Title (Classic)', IT_TEXTDOMAIN ),
			'id' => 'ad_classic_title_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Title (Classic)', IT_TEXTDOMAIN ),
			'id' => 'ad_classic_title_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Before Meta Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays above the meta bar containing the category and metric counts', IT_TEXTDOMAIN ),
			'id' => 'ad_meta_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Meta Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays below the meta bar containing the category and metric counts', IT_TEXTDOMAIN ),
			'id' => 'ad_meta_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),	
		array(
			'name' => __( 'Before Featured Video', IT_TEXTDOMAIN ),
			'id' => 'ad_video_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Featured Video', IT_TEXTDOMAIN ),
			'id' => 'ad_video_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Featured Image', IT_TEXTDOMAIN ),
			'id' => 'ad_image_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Featured Image', IT_TEXTDOMAIN ),
			'id' => 'ad_image_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Details', IT_TEXTDOMAIN ),
			'id' => 'ad_details_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Details', IT_TEXTDOMAIN ),
			'id' => 'ad_details_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Rating Criteria', IT_TEXTDOMAIN ),
			'id' => 'ad_criteria_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Rating Criteria', IT_TEXTDOMAIN ),
			'id' => 'ad_criteria_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Content', IT_TEXTDOMAIN ),
			'id' => 'ad_content_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Content', IT_TEXTDOMAIN ),
			'id' => 'ad_content_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Author Info', IT_TEXTDOMAIN ),
			'id' => 'ad_authorinfo_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Author Info', IT_TEXTDOMAIN ),
			'id' => 'ad_authorinfo_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Recommended', IT_TEXTDOMAIN ),
			'id' => 'ad_recommended_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Recommended', IT_TEXTDOMAIN ),
			'id' => 'ad_recommended_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Before Comments', IT_TEXTDOMAIN ),
			'id' => 'ad_comments_before',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'After Comments', IT_TEXTDOMAIN ),
			'id' => 'ad_comments_after',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Post Loops', IT_TEXTDOMAIN ),
			'desc' => __( 'These ads will get injected into your post loops (article listing pages)', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'AJAX Ads', IT_TEXTDOMAIN ),
			'desc' => __( 'You should turn this off if you are using an ad vendor that does not allow ads to display on dynamically-generated pages such as Google Adsense.', IT_TEXTDOMAIN ),
			'id' => 'ad_ajax',
			'options' => array( 'true' => __( 'Display ads within AJAX (dynamically-loaded) content.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Shuffle', IT_TEXTDOMAIN ),
			'id' => 'ad_shuffle',
			'options' => array( 'true' => __( 'Shuffle the display of the ads', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Number of Ads', IT_TEXTDOMAIN ),
			'desc' => __( 'The total number of ads to display in the loop regardless of how many ad slots are filled out below', IT_TEXTDOMAIN ),
			'id' => 'ad_num',
			'target' => 'ad_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Increment', IT_TEXTDOMAIN ),
			'desc' => __( 'Display an ad every Nth row. For instance, if "3" is selected, every 3rd row will be an ad.', IT_TEXTDOMAIN ),
			'id' => 'ad_increment',
			'target' => 'ad_number',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Off-set', IT_TEXTDOMAIN ),
			'desc' => __( 'Number of rows to display before the first ad appears', IT_TEXTDOMAIN ),
			'id' => 'ad_offset',
			'target' => 'ad_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'desc' => __( 'Enter the HTML for the ad here. Shortcodes work here.', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_1',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_2',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_3',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_4',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_5',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_6',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_7',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_8',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_9',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_10',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Footer
	 */
	array(
		'name' => array( 'it_footer_tab' => $option_tabs ),
		'type' => 'tab_start'
	),		
		array(
			'name' => __( 'Disable Footer', IT_TEXTDOMAIN ),
			'id' => 'footer_disable',
			'options' => array( 'true' => __( 'Completely disable the entire footer area', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Copyright Text', IT_TEXTDOMAIN ),
			'desc' => __( 'This will overwrite the default automatic copyright text in the left of the subfooter.', IT_TEXTDOMAIN ),
			'id' => 'copyright_text',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Credits Text', IT_TEXTDOMAIN ),
			'desc' => __( 'This will overwrite the default automatic credits text in the right of the subfooter.', IT_TEXTDOMAIN ),
			'id' => 'credits_text',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Subfooter', IT_TEXTDOMAIN ),
			'id' => 'subfooter_disable',
			'options' => array( 'true' => __( 'Disable the subfooter area which holds the copyright info', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sociable
	 */
	array(
		'name' => array( 'it_sociable_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Feedburner Feed ID', IT_TEXTDOMAIN ),
			'desc' => __( 'Necessary for the newsletter signup form to function properly. This article explains how to find your feedburner feed name: http://netprofitstoday.com/blog/how-to-find-your-feedburner-id/', IT_TEXTDOMAIN ),
			'id' => 'feedburner_name',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'RSS Feed URL', IT_TEXTDOMAIN ),
			'desc' => __( 'Necessary to connect an RSS button to your actual RSS feed URL.', IT_TEXTDOMAIN ),
			'id' => 'rss_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Twitter Username', IT_TEXTDOMAIN ),
			'desc' => __( 'Not a full URL, just your Twitter username.', IT_TEXTDOMAIN ),
			'id' => 'twitter_username',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Pinterest User URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL for your user profile on Pinterest', IT_TEXTDOMAIN ),
			'id' => 'pinterest_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Google+ Profile URL', IT_TEXTDOMAIN ),
			'desc' => __( "Your actual Google+ profile URL. This is the link users are taken to when they click on the Google+ social count and it is also used to generate your Google+ follower count.", IT_TEXTDOMAIN ),
			'id' => 'googleplus_profile_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Youtube User ID', IT_TEXTDOMAIN ),
			'desc' => __( 'To find your ID, sign in to YouTube and check your Advanced Account Settings page. You will see your ID listed in the Account Information section.', IT_TEXTDOMAIN ),
			'id' => 'youtube_username',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Youtube URL', IT_TEXTDOMAIN ),
			'desc' => __( 'When users click on the subscriber count in your social counts widget they will be taken to this URL.', IT_TEXTDOMAIN ),
			'id' => 'youtube_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Facebook Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Facebook tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		
		array(
			'name' => __( 'Facebook Page URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL of your Facebook page', IT_TEXTDOMAIN ),
			'id' => 'facebook_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Color Scheme', IT_TEXTDOMAIN ),
			'desc' => __( 'Light is better for light backgrounds, dark is better for dark backgrounds', IT_TEXTDOMAIN ),
			'id' => 'facebook_color_scheme',
			'options' => array( 
				'light' => __( 'Light', IT_TEXTDOMAIN ),
				'dark' => __( 'Dark', IT_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		
		array(
			'name' => __( 'Show Faces', IT_TEXTDOMAIN ),
			'id' => 'facebook_show_faces',
			'options' => array( 'true' => __( 'Show profile photos at the bottom', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Show Stream', IT_TEXTDOMAIN ),
			'id' => 'facebook_stream',
			'options' => array( 'true' => __( 'Show the profile stream for the public profile', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Show Header', IT_TEXTDOMAIN ),
			'id' => 'facebook_show_header',
			'options' => array( 'true' => __( 'Show the "Find us on Facebook" bar at the top', IT_TEXTDOMAIN ) ),
			'desc' => __( 'Note: this only displays if either the stream or faces are displayed.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Border Color', IT_TEXTDOMAIN ),
			'desc' => __( 'The color of the borders around the Like Box', IT_TEXTDOMAIN ),
			'id' => 'facebook_border_color',
			'type' => 'color'
		),			
		
		array(
			'name' => __( 'Twitter Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Twitter tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Twitter Widget Code', IT_TEXTDOMAIN ),
			'desc' => __( 'Go to https://twitter.com/settings/widgets and create a new widget. Then put the generated widget code into this box.', IT_TEXTDOMAIN ),
			'id' => 'twitter_widget_code',
			'default' => '',
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Flickr Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Flickr tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		
		array(
			'name' => __( 'Flickr Account ID', IT_TEXTDOMAIN ),
			'desc' => __( 'Your Flickr Account ID. Use this service to find it: http://idgettr.com/', IT_TEXTDOMAIN ),
			'id' => 'flickr_id',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Number of Photos', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of photos to display in the widget.', IT_TEXTDOMAIN ),
			'id' => 'flickr_number',
			'target' => 'flickr_number',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'These social badges appear in the header of your site next to the logo.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
	
		array(
			'name' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'id' => 'sociable',
			'type' => 'sociable'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Advanced
	 */
	array(
		'name' => array( 'it_advanced_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Custom Admin Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to replace the default theme logo.', IT_TEXTDOMAIN ),
			'id' => 'admin_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Disable Image Sizes', IT_TEXTDOMAIN ),
			'desc' => __( 'If you are not using an image size anywhere in your theme and you want to block WordPress from creating an additional image for that size, you can selectively turn off creation of these images here.', IT_TEXTDOMAIN ),
			'id' => 'image_size_disable',
			'options' => array(
				'micro' => __('Micro - smallest sized thumbnails in widgets (30 x 30)',IT_TEXTDOMAIN),
				'menu' => __('Menu - mega menus and "new articles" loops (130 x 75)',IT_TEXTDOMAIN),
				'grid-3' => __('Grid - most grid and overlay loops (400 x 288)',IT_TEXTDOMAIN),
				'grid-4' => __('Grid Wide - wide grid panels (1200 x 334)',IT_TEXTDOMAIN),
				'scroller' => __('Scroller - horizontal scroller and recommended posts (200 x 250)',IT_TEXTDOMAIN),
				'scroller-wide' => __('Scroller Wide - trending and top ten loops (250 x 150)',IT_TEXTDOMAIN),
				'headliner' => __('Headliner - headliner page builder panel (1000 x 60)',IT_TEXTDOMAIN),
				'single-180' => __('Small - featured image on single posts (180px width non-cropped)',IT_TEXTDOMAIN),
				'single-360' => __('Medium - featured image on single posts (360px width non-cropped)',IT_TEXTDOMAIN),
				'single-1200' => __('Full - featured image on single posts (1200px width non-cropped)',IT_TEXTDOMAIN)
			),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Import Options', IT_TEXTDOMAIN ),
			'desc' => __( 'Copy your export code here to import your theme settings.', IT_TEXTDOMAIN ),
			'id' => 'import_options',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Export Options', IT_TEXTDOMAIN ),
			'desc' => __( 'When moving your site to a new Wordpress installation you can export your theme settings here.', IT_TEXTDOMAIN ),
			'id' => 'export_options',
			'type' => 'export_options'
		),
		
		/*array(
			'name' => __( 'Custom Homepage Content', IT_TEXTDOMAIN ),
			'desc' => __( 'You can add some custom content to your homepage. This will display above the post loop on the homepage.', IT_TEXTDOMAIN ),
			'id' => 'homepage_content',
			'type' => 'editor'
		),*/
		
		array(
			'name' => __( 'Disable Unique Views', IT_TEXTDOMAIN ),
			'desc' => __( 'This turns off the ip address check so that every time a page is accessed the view count increments by one.', IT_TEXTDOMAIN ),
			'id' => 'unique_views_disable',
			'options' => array( 'true' => __( 'Post views will increment on every page view', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Allow Unlimited User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This is only for development/testing purposes and will continually add user ratings and re-average the total score each time a user rates a criteria.', IT_TEXTDOMAIN ),
			'id' => 'rating_limit_disable',
			'options' => array( 'true' => __( 'TESTING PURPOSES ONLY', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		
		array(
			'name' => __( 'Allow Unlimited User Reactions', IT_TEXTDOMAIN ),
			'desc' => __( 'This is only for development/testing purposes and will continually stack reactions when users click the reaction buttons instead of "switching" their existing reaction.', IT_TEXTDOMAIN ),
			'id' => 'reaction_limit_disable',
			'options' => array( 'true' => __( 'TESTING PURPOSES ONLY', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		
		array(
			'name' => __( 'Disable Social Click Tracking', IT_TEXTDOMAIN ),
			'id' => 'click_track_disable',
			'options' => array( 'true' => __( 'Disable the click tracking for the social sharing links on pages and posts', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
			
	array(
		'type' => 'tab_end'
	),
	
);

# add woocommerce options
if(function_exists('is_woocommerce')) {
	$woocommerce_options = array(			
		array(
			'name' => array( 'it_woocommerce_tab' => $option_tabs ),
			'type' => 'tab_start'
		),
		array(
			'name' => __( '', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to all WooCommerce related pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable Breadcrumbs', IT_TEXTDOMAIN ),
			'id' => 'woo_breadcrumb_disable',
			'options' => array( 'true' => __( 'Disable the breadcrumb navigation from all woocommerce pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),			
		array(
			'name' => __( 'Show Above', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which page builder components you want to display above the main content of all WooCommerce pages.', IT_TEXTDOMAIN ),
			'id' => 'woo_above_builder',
			'type' => 'builder'
		),
		array(
			'name' => __( 'Show Below', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which page builder components you want to display below the main content of all WooCommerce pages.', IT_TEXTDOMAIN ),
			'id' => 'woo_below_builder',
			'type' => 'builder'
		),		
		array(
			'name' => __( 'Disable Sidebar', IT_TEXTDOMAIN ),
			'id' => 'woo_sidebar_disable',
			'options' => array( 'true' => __( 'Do not display a sidebar for woocommerce pages.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Use "WooCommerce" Sidebar', IT_TEXTDOMAIN ),
			'id' => 'woo_sidebar_unique',
			'options' => array( 'true' => __( 'Use the "WooCommerce" instead of the "Page" sidebar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'type' => 'tab_end'
		)
		
	);
	
	$options = array_merge($options,$woocommerce_options);
}

# add buddypress options
if(function_exists('bp_current_component') || function_exists('is_bbpress')) {
	$buddypress_options = array(			
		array(
			'name' => array( 'it_buddypress_tab' => $option_tabs ),
			'type' => 'tab_start'
		),
		array(
			'name' => __( '', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to all BuddyPress and bbPress related pages unless otherwise noted.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Page Builder', IT_TEXTDOMAIN ),
			'id' => 'bp_builder',
			'type' => 'builder'
		),	
		array(
			'name' => __( 'Disable Sidebar', IT_TEXTDOMAIN ),
			'id' => 'bp_sidebar_disable',
			'options' => array( 'true' => __( 'Do not display a sidebar for buddypress pages.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Use "BuddyPress" Sidebar', IT_TEXTDOMAIN ),
			'id' => 'bp_sidebar_unique',
			'options' => array( 'true' => __( 'Use the "BuddyPress" instead of the "Page" sidebar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Use WordPress Registration', IT_TEXTDOMAIN ),
			'id' => 'bp_register_disable',
			'desc' => __( 'Turn this on if you want to be able to use the registration form in the sticky bar. Otherwise the register link in the sticky bar will redirect the user to the BuddyPress registration page.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Enables registration directly from the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'type' => 'tab_end'
		)
		
	);
	
	$options = array_merge($options,$buddypress_options);
}

return array(
	'load' => true,
	'name' => 'options',
	'options' => $options
);
	
?>
