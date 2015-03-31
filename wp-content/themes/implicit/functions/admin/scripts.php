<?php

/**
 *
 */
function it_admin_enqueue_scripts( $hook ) {
	global $wp_version;	
	if ( in_array( $hook,  array( 'appearance_page_it-options' ) ) ) {

		$url = THEME_URI;
		echo "<script type=\"text/javascript\">
		//<![CDATA[
			var snapAjaxUrl = '$url/lib/admin/ajax',
			    snapWpVersion = '$wp_version';
		//]]>\r</script>\r";

		wp_enqueue_media(); #new 3.5 media uploader		
		wp_enqueue_script( 'wp-color-picker' ); #new 3.5 color picker
		wp_enqueue_style( 'wp-color-picker' ); #new 3.5 color picker
				
		wp_enqueue_style( IT_PREFIX . '-admin', THEME_ADMIN_ASSETS_URI . '/css/admin.css', false, THEME_VERSION, 'screen' );
		wp_enqueue_style( IT_PREFIX . '-admin-icons', THEME_ADMIN_ASSETS_URI . '/css/icons.css', false, THEME_VERSION, 'screen' );
		wp_register_style('Signika', 'http://fonts.googleapis.com/css?family=Signika:400,300,600,700', array(), false, 'screen');
		wp_enqueue_style('Signika');
		
		wp_enqueue_script( 'jquery-ui-sortable', array('jquery') );
		wp_enqueue_script( IT_PREFIX . '-jquery-tools', THEME_ADMIN_ASSETS_URI . '/js/jquery.tools.min.js', array( 'jquery' ), THEME_VERSION ); #used for the admin panel tooltips
		wp_enqueue_script( IT_PREFIX . '-admin-js', THEME_ADMIN_ASSETS_URI . '/js/admin.js', array( 'jquery' ), THEME_VERSION );
		
		wp_localize_script( IT_PREFIX . '-admin-js', 'objectL10n', array(
			'resetConfirm' => __( 'This will restore all theme options to defaults, and it will ALSO restore all widget options and nav menus to defaults. Are you sure?', IT_TEXTDOMAIN ),
			'demoConfirm' => __( 'This will replace all theme options with the demo settings, and it will ALSO replace all widget options and nav menus with the demo settings. Are you sure?', IT_TEXTDOMAIN ),			
			'sidebarEmpty' => __( 'Please enter a name for your sidebar.', IT_TEXTDOMAIN ),
			'sidebarDelete' => __( 'Are you sure you want to delete this sidebar?', IT_TEXTDOMAIN ),
			'typeError' => sprintf( __( '%1$s has invalid extension. Only %2$s are allowed.', IT_TEXTDOMAIN ), '{file}', '{extensions}' ),
			'l10n_print_after' => 'try{convertEntities(objectL10n);}catch(e){};'
		) );
	}	
	
	if ( in_array( $hook,  array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_style( IT_PREFIX . '-admin', THEME_ADMIN_ASSETS_URI . '/css/admin.css', false, THEME_VERSION, 'screen' );
		wp_enqueue_style( IT_PREFIX . '-admin-icons', THEME_ADMIN_ASSETS_URI . '/css/icons.css', false, THEME_VERSION, 'screen' );
		wp_enqueue_script( IT_PREFIX . '-jquery-tools', THEME_ADMIN_ASSETS_URI . '/js/jquery.tools.min.js', array( 'jquery' ), THEME_VERSION );
		wp_enqueue_script( IT_PREFIX . '-admin-js', THEME_ADMIN_ASSETS_URI . '/js/admin.js', array( 'jquery' ), THEME_VERSION );
		wp_enqueue_script( 'wp-color-picker' ); #new 3.5 color picker
		wp_enqueue_style( 'wp-color-picker' ); #new 3.5 color picker
	}	
	
}

/**
 *
 */
function it_tiny_mce_before_init( $initArray ) {
	unset( $initArray['wp_fullscreen_content_css'] );
	$initArray['plugins'] = str_replace( ',wpfullscreen', '', $initArray['plugins'] );
	return $initArray;
}

/**
 *
 */
function it_admin_print_scripts() {
	echo "<script type=\"text/javascript\">
	//<![CDATA[
	jQuery(document).ready(function(){
		alliAdmin.menuSort();
	});
	//]]>\r</script>\r";
}


?>
