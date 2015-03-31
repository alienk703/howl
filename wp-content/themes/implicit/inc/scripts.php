<script type="text/javascript">
	jQuery.noConflict(); 	
	"use strict";		
	//DOCUMENT.READY
	jQuery(document).ready(function() { 				
		//jquery ui slider
		<?php
		global $post;
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($post->ID, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		switch($metric) {
			case 'number':
				$value = 5;
				$min = 0;
				$max = 10;
				$step = .1;
			break;
			case 'percentage':
				$value = 50;
				$min = 0;
				$max = 100;
				$step = 1;
			break;
			case 'letter':
				$value = 7;
				$min = 1;
				$max = 14;
				$step = 1;
			break;
			case 'stars':
				$value = 2.5;
				$min = 0;
				$max = 5;
				$step = .5;
			break;
			default:
				$value = 5;
				$min = 0;
				$max = 10;
				$step = .1;
			break;
		}
		?>
		jQuery('.form-selector').slider({
			value: <?php echo $value; ?>,
			min: <?php echo $min; ?>,
			max: <?php echo $max; ?>,
			step: <?php echo $step; ?>,
			orientation: "horizontal",
			range: "min",
			animate: true,
			slide: function( event, ui ) {
				var rating = ui.value;
				<?php if($metric=='letter') { ?>				
					var numbers = {'1':'F', '2':'F+', '3':'D-', '4':'D', '5':'D+', '6':'C-', '7':'C', '8':'C+', '9':'B-', '10':'B', '11':'B+', '12':'A-', '13':'A', '14':'A+'};					
					var rating = numbers[rating];
				<?php } elseif($metric=='percentage') { ?>	
					var rating = rating + '<span class="percentage">&#37;</span>';
				<?php } ?>			
				jQuery(this).parent().siblings('.rating-value').html( rating );
			}
		});
		<?php if(!it_get_setting('colorbox_disable')) { ?>			
			jQuery('a.featured-image').colorbox({maxWidth:'95%', maxHeight:'95%'});
			jQuery('.colorbox').colorbox({maxWidth:'95%', maxHeight:'95%'});
			jQuery('.colorbox-iframe').colorbox({iframe:true, width:'85%', height:'80%'});
			jQuery(".the-content a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").colorbox({maxWidth:'95%', maxHeight:'95%'}); 
			<?php if(it_get_setting('colorbox_slideshow')) { ?>
				jQuery('.the-content .gallery a').colorbox({rel:'gallery', slideshow:true, maxWidth:'95%', maxHeight:'95%'});
			<?php } else { ?>
				jQuery('.the-content .gallery a').colorbox({rel:'gallery', maxWidth:'95%', maxHeight:'95%'});
			<?php } ?>
		<?php } ?>
	});	
	//WINDOW.LOAD
	jQuery(window).load(function() {		
		//flickr
		<?php #deal with default values
		$flickr_count = it_get_setting('flickr_number');
		if(empty($flickr_count)) $flickr_count=9;
		?>
		if(jQuery('#flickr-social-tab').length > 0) {
			jQuery('.flickr').jflickrfeed({
				limit: <?php echo $flickr_count; ?>,
				qstrings: {
					id: '<?php echo it_get_setting('flickr_id'); ?>'
				},
				itemTemplate: '<li>'+
								'<a rel="colorbox" class="darken small" href="{{image}}" title="{{title}}">' +
									'<img src="{{image_s}}" alt="{{title}}" width="100" height="100" />' +
								'</a>' +
							  '</li>'
			}, function(data) {
			});	
		}					
	});	
	<?php if(it_get_setting('click_track_disable')) { ?>
		var addthis_config = {
			data_track_clickback: false 
		};
	<?php } ?>
	// user rating panel display
	<?php $top_rating_disable = it_get_setting('review_top_rating_disable');
	if((!it_get_setting('review_registered_user_ratings') || is_user_logged_in()) && !$top_rating_disable) { ?>
		jQuery('body').on('mouseover', '.user-rating .rating-wrapper.rateable', function(e) {
			jQuery(this).addClass('over');
			jQuery(this).find('.form-selector-wrapper').fadeIn(100);		
		});
		jQuery('body').on('mouseleave', '.user-rating .rating-wrapper', function(e) {	
			jQuery(this).stop().delay(100)
						.queue(function(n) {
							jQuery(this).removeClass('over');
							n();
						});	
			jQuery(this).find('.form-selector-wrapper').stop().fadeOut(500);		
		});	
	<?php } ?>		
</script>