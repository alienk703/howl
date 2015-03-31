<!DOCTYPE HTML>

<html <?php language_attributes(); ?>>

<head>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />    
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">   
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title><?php wp_title( '|', true, 'right' );?></title>
    
    <?php do_action('it_head'); ?>    
    	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    
    <?php echo it_get_setting('analytics_code'); #google analytics code ?> 
    
	<?php wp_head(); ?>
	
</head>

<?php $body_class = 'it-background woocommerce bp-page'; 
$category_id = it_page_in_category($post->ID);
if($category_id) $body_class .= ' category-' . $category_id;
?>

<body <?php body_class($body_class); ?>>

    <div id="ajax-error"></div>
    
    <div id="fb-root"></div>
    
    <?php it_get_template_part('sticky'); #sticky bar ?>
    
    <?php #determine how far down and left to push main site content
    $sticky_disable = it_get_setting('sticky_disable_global');
    $csssticky = $sticky_disable ? ' no-sticky' : '';
	$nav_hidden = it_get_setting('nav_hidden');
	$nav_disable = it_get_setting('nav_disable');
	$cssnav = $nav_hidden || $nav_disable ? ' nav-hidden' : '';
    ?>
    
    <div class="after-header<?php echo $csssticky; ?>">
    
    	<div class="container-fluid no-padding">
        
        	<div class="row no-margin">
            
            	<div class="col-md-12 no-padding"> 
    
					<?php it_get_template_part('nav'); #sticky nav ?>
                    
                    	<div class="after-nav<?php echo $cssnav; ?>">
                        
                        	<?php if(it_get_setting('ad_header')!='') { #header ad ?>
                        
                                <div class="row it-ad" id="it-ad-header">
                                    
                                    <div class="col-md-12">
                                    
                                        <?php echo do_shortcode(it_get_setting('ad_header')); ?>  
                                        
                                    </div>                    
                                      
                                </div>
                            
                            <?php } ?>