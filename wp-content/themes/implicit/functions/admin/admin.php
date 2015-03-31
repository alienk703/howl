<?php
/**
 * The SnapThemes admin class.
 * The theme admin functions & classes are included & initialized from this file.
 *
 * @package SnapThemes
 * @subpackage Admin
 */

class itAdmin {
	
	/**
	 * Initializes the theme admin framework by loading
	 * required files and functions for the theme options,
	 * meta boxes, skin generator, etc...
	 *
	 * @since 1.0
	 */
	public static function init() {
		self::functions();
		self::classes();
		self::actions();
		self::filters();
		self::metaboxes();
		self::activation();
	}
	
	/**
	 * Loads the theme admin functions.
	 *
	 * @since 1.0
	 */
	public static function functions() {
		require_once( THEME_ADMIN . '/core.php' );
		require_once( THEME_ADMIN . '/scripts.php' );
	}
	
	/**
	 * Loads the theme admin classes.
	 *
	 * @since 1.0
	 */
	public static function classes() {
		require_once( THEME_ADMIN . '/option-generator.php' );
		require_once( THEME_ADMIN . '/metaboxes-generator.php' );
		require_once( THEME_ADMIN . '/shortcode-generator.php' );
	}
	
	/**
	 * Adds the theme admin actions.
	 *
	 * @since 1.0
	 */
	public static function actions() {
		add_action( 'admin_init', 'it_options_init', 1 );
		add_action( 'admin_init', 'it_tinymce_init_size' );
		add_action( 'admin_notices', array( 'itAdmin', 'warnings' ) );
		add_action( 'admin_menu', array( 'itAdmin', 'menus' ) );
		add_action( 'admin_enqueue_scripts', 'it_admin_enqueue_scripts' );
		add_action( 'appearance_page_it-options', 'it_admin_print_scripts' );
		if ( isset( $_GET['it_upload_button'] ) || isset( $_POST['it_upload_button'] ) )
			add_action( 'admin_init', 'it_image_upload_option' );
	}
	
	/**
	 * Adds the theme admin filters.
	 *
	 * @since 1.0
	 */
	public static function filters() {
		if( isset( $_GET['page'] ) && $_GET['page'] == 'it-options' )
			add_filter( 'tiny_mce_before_init', 'it_tiny_mce_before_init' );
	}
	
	/**
	 * Adds the theme options menu.
	 *
	 * @since 1.0
	 */
	public static function menus() {
		add_theme_page( THEME_NAME, "Theme Options", 'edit_theme_options', 'it-options', array( 'itAdmin', 'options' ) );
	}
	
	/**
	 * Creates the theme options menu.
	 *
	 * @since 1.0
	 */
	public static function options() {
		$page = include( THEME_ADMIN . '/' . $_GET['page'] . '.php' );
		
		if( $page['load'] ) {
			new itOptionGenerator( $page['options'] );
		}
	}
	
	/**
	 * Adds the theme post/page metaboxes.
	 *
	 * @since 1.0
	 */
	public static function metaboxes() {		
		$page = include( THEME_ADMIN . '/meta-page.php' );
		$directory = include( THEME_ADMIN . '/meta-directory.php' );
		$post = include( THEME_ADMIN . '/meta-post.php' );
		$review = include( THEME_ADMIN . '/meta-review.php' );
		$awards = include( THEME_ADMIN . '/meta-awards.php' );
		$badges = include( THEME_ADMIN . '/meta-badges.php' );
		$reactions = include( THEME_ADMIN . '/meta-reactions.php' );
		$details = include( THEME_ADMIN . '/meta-details.php' );
		$reset = include( THEME_ADMIN . '/meta-reset.php' );
		
		# setup post type array
		$pages = array( 'page', 'post' );
		
		# add shortcodes
		new itShortcodeMetaBox( $pages );		
			
		# add the rest of the meta boxes
		if( $page['load'] ) {
			new itMetaBox( $page['options'] );
			new itMetaBox( $directory['options'] );
		}			
		if( $post['load'] ) {
			new itMetaBox( $post['options'] );
			new itMetaBox( $review['options'] );
			new itMetaBox( $awards['options'] );
			new itMetaBox( $badges['options'] );
			new itMetaBox( $reactions['options'] );			
			#selectively add details	
			$review_details = it_get_setting('review_details');	
			if($review_details['keys'] != '#' ) new itMetaBox( $details['options'] );
			new itMetaBox( $reset['options'] );
		}
	}
	
	/**
	 * Checks & functions to run on theme activation.
	 *
	 * @since 1.0
	 */
	public static function activation() {
		global $pagenow, $wp_rewrite;
		
		$return = '<a href="' . admin_url( 'themes.php' ) . '">' . __( 'OK got it! &raquo;', IT_TEXTDOMAIN ) . '</a>';
		
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

			# Check php version
			if( version_compare( PHP_VERSION, '5', '<' ) ) {
				switch_theme( 'twentyfourteen', 'twentyfourteen' );				
				wp_die(sprintf( __( 'Your PHP version is too old, please upgrade to a newer version. Your version is %s, %s requires %s', IT_TEXTDOMAIN ), phpversion(), THEME_NAME, '5.0' ) . $return );
			}
			
			# Check for mb_strlen
			if( !function_exists('mb_strlen') ) {
				switch_theme( 'twentyfourteen', 'twentyfourteen' );
				wp_die(sprintf( __( '%s is required to install %s. Please enable this function on your web server. ', IT_TEXTDOMAIN ), 'mb_strlen()', THEME_NAME ) . $return );
			}
			
			# Add default widgets && show_on_front 'posts'
			if( get_option( IT_SETTINGS ) == false ) {				
				it_options( 'widgets', 'default' );
				update_option( 'show_on_front', 'posts' ); 
			}
				
			# flush rewrite rules
			$wp_rewrite->flush_rules();
		}
	}
	
	/**
	 * Check current environment is supported for the theme.
	 * 
	 * @since 1.0
	 */
	public static function warnings(){
		global $wp_version;

		$errors = array();
		
		if( !it_check_wp_version() )
			$errors[]='Wordpress version('.$wp_version.') is too low. Please upgrade to 3.8';
		
		if( !empty( $errors ) ) {
			$str = '<ul>';
			foreach($errors as $error){
				$str .= '<li>'.$error.'</li>';
			}
			$str .= '</ul>';
			echo '<div class="error fade"><p><strong>' . sprintf( __( '%1$s Error Messages', IT_TEXTDOMAIN ), THEME_NAME ) . '</strong><br />' . $str . '</p></div>';
		}
	}
	
}

?>
