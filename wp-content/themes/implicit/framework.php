<?php
# The IndustrialThemes class. Defines constants and includes files for theme functions.

class IndustrialThemes {
	
	public static function init( $options ) {
		self::constants( $options );
		self::functions();
		self::actions();
		self::filters();
		self::supports();
		self::locale();
		self::admin();
	}
	
	# define constant variables
	public static function constants( $options ) {
		define( 'THEME_NAME', $options['theme_name'] );
		define( 'THEME_SLUG', get_template() );
		define( 'THEME_VERSION', $options['theme_version'] );
		define( 'THEME_URI', get_template_directory_uri() );
		define( 'THEME_DIR', get_template_directory() );
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
		define( 'FRAMEWORK_VERSION', '1.0' );
		define( 'DEMO_URL', 'http://www.industrialthemes.com/implicit' );
		define( 'SUPPORT_URL', DEMO_URL . '/support' );
		define( 'CREDITS_URL', SUPPORT_URL . '/credits' );
		define( 'DOCUMENTATION_URL', THEME_URI . '/documentation' );
		
		define( 'IT_PREFIX', 'it' );
		define( 'IT_TEXTDOMAIN', THEME_SLUG );
		define( 'IT_SETTINGS', 'it_' . THEME_SLUG . '_options' );	
		define( 'IT_WIDGETS', 'sidebars_widgets' );	
		define( 'IT_MODS', 'theme_mods_' . THEME_SLUG );
		define( 'IT_INTERNAL_SETTINGS', 'it_' . THEME_SLUG . '_internal_options' );
		define( 'IT_SIDEBARS', 'it_' . THEME_SLUG . '_sidebars' );
		define( 'IT_LETTER_ARRAY', 'A+,A,A-,B+,B,B-,C+,C,C-,D+,D,D-,F+,F,F-' );
		define( 'IT_META_TOTAL_LIKES', '_total_likes');
		define( 'IT_META_LIKE_IP_LIST', '_like_ip_list');
		define( 'IT_META_TOTAL_VIEWS', '_total_views');
		define( 'IT_META_VIEW_IP_LIST', '_view_ip_list');
		define( 'IT_META_TOTAL_SCORE', '_total_score');
		define( 'IT_META_TOTAL_SCORE_OVERRIDE', '_total_score_override');
		define( 'IT_META_TOTAL_USER_SCORE', '_total_user_score');
		define( 'IT_META_TOTAL_SCORE_NORMALIZED', '_total_score_normalized');
		define( 'IT_META_TOTAL_USER_SCORE_NORMALIZED', '_total_user_score_normalized');
		define( 'IT_META_USER_PROS_IP_LIST', '_user_pros_ip_list');
		define( 'IT_META_USER_CONS_IP_LIST', '_user_cons_ip_list');
		define( 'IT_META_USER_PROS_ID_LIST', '_user_pros_id_list');
		define( 'IT_META_USER_CONS_ID_LIST', '_user_cons_id_list');
		define( 'IT_META_AWARDS', '_awards');
		define( 'IT_META_BADGES', '_badges');
		define( 'IT_META_REACTIONS', '_reactions');
		define( 'IT_META_TOTAL_REACTIONS', '_total_reactions');
		define( 'IT_META_POSITIVES', '_positives');
		define( 'IT_META_NEGATIVES', '_negatives');
		define( 'IT_META_BOTTOM_LINE', '_bottom_line');
		define( 'IT_META_POST_TYPE', '_post_type');
		define( 'IT_META_METRIC', '_rating_metric');
		define( 'IT_META_DISABLE_REVIEW', '_disable_review');
		define( 'IT_META_DISABLE_TITLE', '_disable_title');
		define( 'IT_TWITTER_CONSUMER_KEY', 'mpcfoMr7pdqvRQpzatsw');
		define( 'IT_TWITTER_CONSUMER_SECRET', 'l6WI9nHGeieteHE9xKg1OPb1xNTlsx2epRqsR0Qo0');
		define( 'IT_TWITTER_USER_TOKEN', '602882281-4i3cRDVXMjHSOAVIUCe4UPcn4trwGzqvziNyNsAp');
		define( 'IT_TWITTER_USER_SECRET', 'QCBg30c2ZfrDk8R4laYWb5M0DthfMrLvKdvqa5WR4');	
		define( 'IT_META_AFFILIATE_CODE', '_affiliate_code');	
		
		define( 'THEME_FUNCTIONS', THEME_DIR . '/functions' );
		define( 'THEME_IMAGES', THEME_URI . '/images' );
		define( 'THEME_SHORTCODES', THEME_FUNCTIONS . '/shortcodes' );
		define( 'THEME_WIDGETS', THEME_FUNCTIONS . '/widgets' );		
		define( 'THEME_JS_URI', THEME_URI . '/js' );		
		define( 'THEME_ADMIN', THEME_FUNCTIONS . '/admin' );
		define( 'THEME_ADMIN_ASSETS_URI', THEME_URI . '/functions/admin/assets' );
		
		define( 'CHILD_THEME_FUNCTIONS', CHILD_THEME_DIR . '/functions' );
		define( 'CHILD_THEME_IMAGES', CHILD_THEME_URI . '/images' );
		define( 'CHILD_THEME_SHORTCODES', CHILD_THEME_FUNCTIONS . '/shortcodes' );
		define( 'CHILD_THEME_WIDGETS', CHILD_THEME_FUNCTIONS . '/widgets' );
		define( 'CHILD_THEME_JS_URI', CHILD_THEME_URI . '/js' );
		define( 'CHILD_THEME_ADMIN', CHILD_THEME_FUNCTIONS . '/admin' );
		define( 'CHILD_THEME_ADMIN_ASSETS_URI', CHILD_THEME_URI . '/functions/admin/assets' );
	}
		
	# get theme functions
	public static function functions() {
		if ( file_exists( CHILD_THEME_FUNCTIONS . '/core.php' ) )
			require_once( CHILD_THEME_FUNCTIONS . '/core.php' );
		else if ( file_exists( THEME_FUNCTIONS . '/core.php' ) )
			require_once( THEME_FUNCTIONS . '/core.php' );
		if ( file_exists( CHILD_THEME_FUNCTIONS . '/ajax.php' ) )
			require_once( CHILD_THEME_FUNCTIONS . '/ajax.php' );
		else if ( file_exists( THEME_FUNCTIONS . '/ajax.php' ) )
			require_once( THEME_FUNCTIONS . '/ajax.php' );
		if ( file_exists( CHILD_THEME_FUNCTIONS . '/theme.php' ) )
			require_once( CHILD_THEME_FUNCTIONS . '/theme.php' );
		else if ( file_exists( THEME_FUNCTIONS . '/theme.php' ) )
			require_once( THEME_FUNCTIONS . '/theme.php' );	
		if ( file_exists( CHILD_THEME_FUNCTIONS . '/reviews.php' ) )
			require_once( CHILD_THEME_FUNCTIONS . '/reviews.php' );
		else if ( file_exists( THEME_FUNCTIONS . '/reviews.php' ) )
			require_once( THEME_FUNCTIONS . '/reviews.php' );
		if ( file_exists( CHILD_THEME_FUNCTIONS . '/loop.php' ) )
			require_once( CHILD_THEME_FUNCTIONS . '/loop.php' );
		else if ( file_exists( THEME_FUNCTIONS . '/loop.php' ) )
			require_once( THEME_FUNCTIONS . '/loop.php' );
		#purely utility, not used by the theme directly
		if ( file_exists( CHILD_THEME_FUNCTIONS . '/options.php' ) )
			require_once( CHILD_THEME_FUNCTIONS . '/options.php' );
		else if ( file_exists( THEME_FUNCTIONS . '/options.php' ) )
			require_once( THEME_FUNCTIONS . '/options.php' );
	}
	
	# setup theme actions
	public static function actions() {
		#WORDPRESS ACTIONS
		add_action( 'init', 'it_shortcodes_init' );
		add_action( 'init', 'it_custom_menus' );
		add_action( 'widgets_init', 'it_sidebars' );
		add_action( 'widgets_init', 'it_widgets' );	
		add_action( 'login_head', 'it_custom_login_logo' );
		add_action( 'wp_enqueue_scripts', 'it_enqueue_scripts' );
		add_action( 'wp_footer', 'it_footer_scripts', 99 );
		add_action( 'show_user_profile', 'it_user_profile_fields' );
		add_action( 'edit_user_profile', 'it_user_profile_fields' );
		add_action( 'personal_options_update', 'it_save_profile_fields' );
		add_action( 'edit_user_profile_update', 'it_save_profile_fields' );
		if(!it_get_setting('review_registered_user_ratings') || is_user_logged_in()) {
			add_action( 'comment_form_top', 'it_before_comment_fields' );
			add_action( 'comment_form', 'it_after_comment_fields' ); #appears after textarea (comment_form_after_fields appears BEFORE textarea)
			add_action( 'comment_post', 'it_save_comment_meta');
		}
		add_action( 'pre_comment_on_post', 'it_hide_comment');
		
		#THEME ACTIONS
		
		#head
		add_action( 'it_head', 'it_header_scripts' );
		add_action( 'it_head', 'it_facebook_image' );
		
		#page builder panels	
		add_action( 'it_before_grid', 'it_show_ad', 10, 2 );
		add_action( 'it_after_grid', 'it_show_ad', 10, 3 );
		add_action( 'it_after_grid', 'it_hide_pagination' );
		add_action( 'it_before_list', 'it_show_ad', 10, 2 );
		add_action( 'it_after_list', 'it_show_ad', 10, 3 );
		add_action( 'it_after_list', 'it_hide_pagination' );	
		add_action( 'it_before_scroller', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_scroller', 'it_show_ad', 10, 2 );
		add_action( 'it_before_headliner', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_headliner', 'it_show_ad', 10, 2 );
		add_action( 'it_before_connect', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_connect', 'it_show_ad', 10, 2 );
		add_action( 'it_before_widgets', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_widgets', 'it_show_ad', 10, 2 );
		add_action( 'it_before_topten', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_topten', 'it_show_ad', 10, 2 );
		add_action( 'it_before_trending', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_trending', 'it_show_ad', 10, 2 );
		add_action( 'it_before_utility', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_utility', 'it_show_ad', 10, 2 );
		add_action( 'it_before_html', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_html', 'it_show_ad', 10, 2 );		
		
		#single pages
		#add_action( 'it_before_content_page', 'it_user_view' );	
		#add_action( 'it_after_content_page', '' );	
		add_action( 'it_before_directory', 'it_show_ad', 10, 2 );	
		add_action( 'it_after_directory', 'it_show_ad', 10, 2 );
		add_action( 'it_before_longform_title', 'it_show_ad', 10, 2 );
		add_action( 'it_after_longform_title', 'it_show_ad', 10, 2 );		
		add_action( 'it_before_billboard_title', 'it_show_ad', 10, 2 );
		add_action( 'it_after_billboard_title', 'it_show_ad', 10, 2 );
		add_action( 'it_before_classic_title', 'it_show_ad', 10, 2 );
		add_action( 'it_after_classic_title', 'it_show_ad', 10, 2 );		
		add_action( 'it_before_metabar', 'it_show_ad', 10, 2 );
		add_action( 'it_after_metabar', 'it_show_ad', 10, 2 );	
		add_action( 'it_before_featured_video', 'it_show_ad', 10, 2 );
		add_action( 'it_after_featured_video', 'it_show_ad', 10, 2 );
		add_action( 'it_before_featured_image', 'it_show_ad', 10, 2 );
		add_action( 'it_after_featured_image', 'it_show_ad', 10, 2 );		
		add_action( 'it_before_details', 'it_show_ad', 10, 2 );
		add_action( 'it_after_details', 'it_show_ad', 10, 2 );
		add_action( 'it_before_criteria', 'it_show_ad', 10, 2 );
		add_action( 'it_after_criteria', 'it_show_ad', 10, 2 );
		add_action( 'it_before_reactions', 'it_show_ad', 10, 2 );
		add_action( 'it_after_reactions', 'it_show_ad', 10, 2 );		
		add_action( 'it_before_content', 'it_show_ad', 10, 2 );
		add_action( 'it_after_content', 'it_show_ad', 10, 2 );
		add_action( 'it_after_content', 'it_post_pagination' );
		add_action( 'it_before_authorinfo', 'it_show_ad', 10, 2 );
		add_action( 'it_after_authorinfo', 'it_show_ad', 10, 2 );
		add_action( 'it_before_recommended', 'it_show_ad', 10, 2 );
		add_action( 'it_after_recommended', 'it_show_ad', 10, 2 );
		add_action( 'it_before_comments', 'it_show_ad', 10, 2 );
		add_action( 'it_after_comments', 'it_show_ad', 10, 2 );		
		
		#footer	
		add_action( 'it_body_end', 'it_footer_styles' );	
		add_action( 'it_body_end', 'it_custom_javascript' );
		
		#AJAX ACTIONS
		add_action( 'wp_ajax_nopriv_itajax-view', 'itajax_view' );
		add_action( 'wp_ajax_itajax-view', 'itajax_view' );
		add_action( 'wp_ajax_nopriv_itajax-share', 'itajax_share' );
		add_action( 'wp_ajax_itajax-share', 'itajax_share' );
		add_action( 'wp_ajax_nopriv_itajax-like', 'itajax_like' );
		add_action( 'wp_ajax_itajax-like', 'itajax_like' );
		add_action( 'wp_ajax_nopriv_itajax-reaction', 'itajax_reaction' );
		add_action( 'wp_ajax_itajax-reaction', 'itajax_reaction' );
		add_action( 'wp_ajax_nopriv_itajax-user-rate', 'itajax_user_rate' );
		add_action( 'wp_ajax_itajax-user-rate', 'itajax_user_rate' );
		add_action( 'wp_ajax_nopriv_itajax-menu-terms', 'itajax_menu_terms' );
		add_action( 'wp_ajax_itajax-menu-terms', 'itajax_menu_terms' );
		add_action( 'wp_ajax_nopriv_itajax-sort', 'itajax_sort' );
		add_action( 'wp_ajax_itajax-sort', 'itajax_sort' );				
		
		#WOOCOMMERCE ACTIONS
		
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
		add_action('woocommerce_before_main_content', 'it_wrapper_start', 10);
		add_action('woocommerce_after_main_content', 'it_wrapper_end', 10);
		
		#BUDDYPRESS ACTIONS
		
		add_action( 'bp_loaded', 'it_disable_bp_registration' );
	}

	# setup theme filters
	public static function filters() {
		# WordPress filters		
		add_filter( 'wp_title', 'it_wp_title', 10, 2 );
		remove_filter('get_the_excerpt', 'wp_trim_excerpt');
		add_filter('get_the_excerpt', 'it_excerpt_adjust');
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'widget_text', 'shortcode_unautop');
		add_filter( 'get_comment_author_link', 'author_link_new_window' );	
		#add_filter( 'wp_redirect', 'wpse12721_wp_redirect' );
		add_filter( 'bp_get_signup_page', "it_redirect_bp_signup_page");
		add_filter( 'embed_oembed_html', 'it_embed_html', 10, 3 );
		add_filter( 'video_embed_html', 'it_embed_html' ); #Jetpack
		add_filter( 'no_texturize_shortcodes', 'it_shortcodes_exempt' );
	}
	
	# setup theme supports
	public static function supports() {
		
		add_theme_support( 'menus' );
		add_theme_support( 'widgets' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );		
		add_theme_support( 'bbpress' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'woocommerce' );
		
		$disabled = ( is_array( it_get_setting("image_size_disable") ) ) ? it_get_setting("image_size_disable") : array();
		
		#featured image sizes
		if(!in_array('micro', $disabled)) add_image_size( 'micro', 30, 30, true );
		if(!in_array('menu', $disabled)) add_image_size( 'menu', 130, 75, true );
		if(!in_array('grid', $disabled)) add_image_size( 'grid', 400, 288, true );
		if(!in_array('grid-wide', $disabled)) add_image_size( 'grid-wide', 1200, 334, true );
		if(!in_array('scroller', $disabled)) add_image_size( 'scroller', 200, 250, true );
		if(!in_array('scroller-wide', $disabled)) add_image_size( 'scroller-wide', 250, 150, true );
		if(!in_array('headliner', $disabled)) add_image_size( 'headliner', 1000, 60, true );
				
		#single posts/pages
		if(!in_array('single-180', $disabled)) add_image_size( 'single-180', 180 );
		if(!in_array('single-360', $disabled)) add_image_size( 'single-360', 360 );
		if(!in_array('single-1200', $disabled)) add_image_size( 'single-1200', 1200 );
	}

	# handles localization file
	public static function locale() {
		# Get the user's locale.
		$locale = get_locale();		
		
		# Load theme textdomain.
		load_theme_textdomain( IT_TEXTDOMAIN, THEME_DIR . '/lang' );
		$locale_file = THEME_DIR . "/lang/$locale.php";
		
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );
	}
	
	# setup theme admin
	private static function admin() {
		if( !is_admin() ) return;
			
		require_once( THEME_ADMIN . '/admin.php' );
		itAdmin::init();
	}
	
}
?>