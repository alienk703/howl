<?php
$postid = isset($post) ? $post->ID : '';
$unstick=it_get_setting('sticky_unstick');
$nav_hidden = it_get_setting('nav_hidden');
$nav_disable = it_get_setting('nav_disable');
$tagline_disable = true;
if(!it_get_setting('description_disable') && get_bloginfo('description')!=='') $tagline_disable = false;
#logo setup
$logo_url=it_get_setting('logo_url');
$logo_url_hd=it_get_setting('logo_url_hd');
$logo_width=it_get_setting('logo_width');
$logo_height=it_get_setting('logo_height');
$logo_url_mobile=it_get_setting('logo_mobile_url');
$logo_url_hd_mobile=it_get_setting('logo_mobile_url_hd');
$logo_width_mobile=it_get_setting('logo_mobile_width');
$logo_height_mobile=it_get_setting('logo_mobile_height');
$logo_disable=it_get_setting('logo_disable_global');
$dimensions = '';
$dimensions_mobile = '';
#category specific logo
$category_id = it_page_in_category($postid);
if($category_id) {
	$categories = it_get_setting('categories');	 
	foreach($categories as $category) {
		if(is_array($category)) {
			if(array_key_exists('id',$category)) {
				if($category['id'] == $category_id) {
					if(!empty($category['logo'])) $logo_url=$category['logo'];
					if(!empty($category['logohd'])) $logo_url_hd=$category['logohd'];
					if(!empty($category['logowidth'])) $logo_width=$category['logowidth'];
					if(!empty($category['logoheight'])) $logo_height=$category['logoheight'];
					$logo_url_mobile = !empty($category['logo_mobile']) ? $logo_url_mobile=$category['logo_mobile'] : '';
					$logo_hd_url_mobile = !empty($category['logohd_mobile']) ? $logo_url_hd_mobile=$category['logohd_mobile'] : '';
					$logo_width_mobile = !empty($category['logowidth_mobile']) ? $logo_width_mobile=$category['logowidth_mobile'] : '';
					$logo_height_mobile = !empty($category['logoheight_mobile']) ? $logo_height_mobile=$category['logoheight_mobile'] : '';
					if(array_key_exists('tagline_disable',$category)) {
						if($category['tagline_disable']) $tagline_disable = true;
					}
					break;
				}
			}
		}
	}
}
#set dimension css
if(!empty($logo_width)) $dimensions .= ' width="'.$logo_width.'"';
if(!empty($logo_height)) $dimensions .= ' height="'.$logo_height.'"';
if(!empty($logo_width_mobile)) $dimensions_mobile .= ' width="'.$logo_width_mobile.'"';
if(!empty($logo_height_mobile)) $dimensions_mobile .= ' height="'.$logo_height_mobile.'"';
#logo fallbacks
if(empty($logo_url_hd)) $logo_url_hd = $logo_url;
if(empty($logo_url_mobile)) $logo_url_mobile = $logo_url;
if(empty($logo_url_hd_mobile)) $logo_url_hd_mobile = $logo_url_mobile;
if(empty($dimensions_mobile)) $dimensions_mobile = $dimensions;
#setup sticky bar css
$cssadmin = is_admin_bar_showing() ? ' admin-bar' : '';
$csssticky = $unstick ? ' unstick' : '';
$cssnav = $nav_hidden ? ' nav-hidden' : '';
#setup login/register variables
$idregister = 'sticky-register';
$hrefregister = '';
$hrefaccount = force_ssl_admin() ? str_replace('http://','https://',admin_url( 'profile.php' )) : admin_url( 'profile.php' );
#if buddypress is active the register button should redirect to the register page
#and the account button should redirect to the BuddyPress profile page
if(function_exists('bp_current_component') && !it_get_setting('bp_register_disable')) {
	$idregister = 'sticky-register-bp';
	$hrefregister = 'href="' . home_url() . '/register"';
	$hrefaccount = bp_loggedin_user_domain();
}
#disable login form and use standard WP login page instead
$idlogin = 'sticky-login';
$hreflogin = '';
if(it_get_setting('sticky_force_wp_login')) {
	$idlogin = 'sticky-login-wp';
	$hreflogin = 'href="' . wp_login_url( home_url() ) . '"';
}
?>

<?php if (!it_component_disabled('sticky', $postid)) { ?>

	<div class="container-fluid no-padding">
   
        <div id="sticky-bar" class="<?php echo $cssadmin . $csssticky . $cssnav; ?>">
            
            <div class="row"> 
            
                <div class="col-md-12"> 
                    
                    <div id="sticky-inner">
                    
                    	<?php if(!$nav_disable) { ?>
                        
                        	<div class="nav-toggle add-active"><span class="theme-icon-list"></span></div>
                        
                        <?php } ?>
                    
						<?php if(!$logo_disable) { ?>
                        
                            <div class="logo">
        
                                <?php if(it_get_setting('display_logo') && $logo_url!='') { ?>
                                    <a href="<?php echo home_url(); ?>/" title="<?php _e('Home',IT_TEXTDOMAIN); ?>">
                                        <img id="site-logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url; ?>"<?php echo $dimensions; ?> />   
                                        <img id="site-logo-hd" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd; ?>"<?php echo $dimensions; ?> />  
                                        <img id="site-logo-mobile" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_mobile; ?>"<?php echo $dimensions_mobile; ?> />   
                                        <img id="site-logo-hd-mobile" alt="<?php bloginfo('name'); ?>" src="<?php echo $logo_url_hd_mobile; ?>"<?php echo $dimensions_mobile; ?> /> 
                                    </a>
                                <?php } else { ?>     
                                    <h1><a href="<?php echo home_url(); ?>/" title="<?php _e('Home',IT_TEXTDOMAIN); ?>"><?php bloginfo('name'); ?></a></h1>
                                <?php } ?>
                                
                            </div>
                        
                        <?php } ?>
                        
                        <?php if(!$tagline_disable) { ?>
                                        
                            <div class="subtitle"><?php bloginfo('description'); ?></div>
                            
                        <?php } ?>
                    
                        <div id="sticky-controls">
                        
                        	<?php if(!it_get_setting('search_disable')) { ?>
                    
                                <div id="menu-search" class="info-bottom" title="<?php _e('Type and hit Enter',IT_TEXTDOMAIN); ?>">
                                
                                    <span class="theme-icon-search"></span>
                                
                                    <form method="get" id="searchformtop" action="<?php echo home_url(); ?>/">                             
                                        <input type="text" placeholder="<?php _e( 'search', IT_TEXTDOMAIN ); ?>" name="s" id="s" />          
                                    </form>
                                    
                                </div>
                                
                            <?php } ?>
                            
                            <?php if(!it_get_setting('sticky_account_disable')) { ?> 
                            
                            	<div class="sticky-button-wrapper">
                                
                                	<a id="sticky-account" class="info-bottom theme-icon-username sticky-button" title="<?php _e('Account',IT_TEXTDOMAIN); ?>"></a>
                                
                                    <div class="sticky-dropdown clearfix" id="sticky-account-dropdown">             
                                
                                        <?php global $user_ID, $user_identity; get_currentuserinfo(); if (!$user_ID) { ?>
                                        
                                        	<div class="clearfix">
                                        
                                                <a id="<?php echo $idlogin; ?>" <?php echo $hreflogin; ?> class="sticky-dropdown-button active"><?php _e('LOGIN',IT_TEXTDOMAIN); ?></a>
                                                
                                                <a id="<?php echo $idregister; ?>" <?php echo $hrefregister; ?> class="sticky-dropdown-button"><?php _e('REGISTER',IT_TEXTDOMAIN); ?></a> 
                                                
                                            </div> 
                                            
                                            <div class="sticky-form-placeholder">
                                            
                                                <div class="loading"><span class="theme-icon-spin2"></span></div>
                                            
                                                <?php echo it_login_form(); ?>
                                            
                                                <?php echo it_register_form(); ?>
                                            
                                            </div>                      
                                        
                                        <?php } else { ?>
                                        
                                            <a class="sticky-dropdown-button large has-icon" href="<?php echo $hrefaccount; ?>"><span class="theme-icon-cog"></span><?php _e('ACCOUNT',IT_TEXTDOMAIN); ?></a>
                                            
                                            <a class="sticky-dropdown-button large has-icon" href="<?php echo wp_logout_url( home_url() ); ?>"><span class="theme-icon-logout"></span><?php _e('LOGOUT',IT_TEXTDOMAIN); ?></a>                                   
                                        
                                        <?php } ?>
                                    
                                    </div>
                                    
                                    <?php  $register = 'false';
                                    if(!empty($_GET)) {
                                        if(array_key_exists('register', $_GET)) $register = $_GET['register']; 
                                    }
                                    if($register == 'true') { ?>
                                    
                                        <div class="sticky-dropdown check-password info" title="<?php _e('click to dismiss',IT_TEXTDOMAIN); ?>" data-placement="bottom">
                                            
                                            <span class="theme-icon-thumbs-up"></span>
                                    
                                            <?php _e('Check your email for your password.',IT_TEXTDOMAIN); ?>
                                        
                                        </div>
                                    
                                    <?php } ?>
                                    
                                <?php } ?>
                            
                            </div> 
                            
                            <?php if(!it_get_setting('sticky_social_disable')) { ?>  
                            
                            	<div class="sticky-button-wrapper">
                            
                            		<a id="sticky-social" class="info-bottom theme-icon-plus sticky-button" title="<?php _e('Find Us!',IT_TEXTDOMAIN); ?>"></a>
                                
                                    <div class="sticky-dropdown clearfix" id="sticky-social-dropdown">
                                    
                                        <div class="sticky-dropdown-label"><?php _e('FIND US!',IT_TEXTDOMAIN); ?></div>
                                    
                                        <?php echo it_social_badges('bottom'); ?>
                                    
                                    </div>
                                
                                </div>
                            
                            <?php } ?>
                            
                            <?php if(!it_get_setting('sticky_backtotop_disable')) { ?>
                            
                            	<a id="back-to-top" href="#top" class="info theme-icon-up-open sticky-button" title="<?php _e('Top',IT_TEXTDOMAIN); ?>" data-placement="bottom"></a> 
                                
                            <?php } ?>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
    
        </div>
        
    </div>

<?php } wp_reset_query();?>