<?php 
/*
this file contains functions related to theme presentation
specific to reviews
*/

/**
 * Class: itAward
 *
 * new itAward(string name);
 *
 * name = the user visible name, example: Editor's Choice
 */
class itAward{
	public $name = null;
	public $slug = null;
	public $meta_name = null;
	public $icon = null;
	public $iconhd = null;
	public $iconwhite = null;
	public $iconhdwhite = null;
	public $isBadge = false;

	function __construct($name, $slug, $icon, $iconhd, $iconwhite = NULL, $iconhdwhite = NULL, $isBadge = false, $meta_name = NULL){
		$this->name = $name;
		
		#$meta_name = '_' . strtolower(str_replace(" ","_",$name));
		$meta_name = '_' . it_get_slug($slug, $name);
		
		$this->meta_name = $meta_name;
		$this->icon = $icon;
		$this->iconhd = $iconhd;
		$this->iconwhite = $iconwhite;
		$this->iconhdwhite = $iconhdwhite;
		$this->isBadge = $isBadge;
	}
}

/**
 * Class: itDetail
 *
 * new itDetail(string name);
 *
 * name = the user visible name, example: Type
 */
class itDetail{
	public $name = null;
	public $safe_name = null;
	public $meta_name = null;

	function __construct($name, $safe_name = NULL, $meta_name = NULL){
		$this->name = $name;
		
		$safe_name = strtolower(str_replace(" ","_",$name));
        $meta_name = '_' . $safe_name;
		
		$this->safe_name = $safe_name;
		$this->meta_name = $meta_name;
	}
}

/**
 * Class: itCriteria
 *
 * new itCriteria(string name, string weight);
 *
 * name = the name of the custom meta field used for the criteria, example: Usability
 * weight = the multiplier of the criteria, example: 2
 */
class itCriteria {
	public $name = null;
	public $weight = null;	
	public $safe_name = null;
	public $meta_name = null;

	function __construct($name, $weight, $safe_name = NULL, $meta_name = NULL){
		$this->name = $name;
		$this->weight = $weight;
		
		$safe_name = strtolower(str_replace(" ","_",$name));
        $meta_name = '_'.$safe_name;
		
		$this->safe_name = $safe_name;
		$this->meta_name = $meta_name;
	}
}
if(!function_exists('it_get_awards')) {
	#html display of awards and badges
	function it_get_awards($args) {
		extract($args);
		$current_awards = array();
		$first = $single;
		#get awards
		$awards = it_get_setting('review_awards');
		$meta_name = IT_META_AWARDS;
		if($badge) $meta_name = IT_META_BADGES;
		#get awards for this post
		$meta = get_post_meta($postid, $meta_name, $single = true);			
		#if(strpos($meta,"_editor\'s_pick") > 0) delete_post_meta($postid, IT_META_AWARDS); #just a little nuance from development that no longer exists
		#see if any awards exist
		if(empty($meta)) {
			return false;
		} else {
			if(unserialize($meta)) $meta = unserialize($meta);	
			$current_awards = $meta;
		}
		$i=0;
		$out='';
		$style='';
		if($wrapper) {		
			if($badge) {
				$out .= '<div class="badges-wrapper">';
			} else {
				$out .= '<div class="awards-wrapper">';
			}
		}
		#loop through all awards
		foreach($awards as $award){	
			if(is_array($award)) {
				if(array_key_exists(0, $award)) {
					$i++;								
					$name = stripslashes($award[0]->name);
					$meta_name = stripslashes($award[0]->meta_name);
					#this award is assigned to this post
					if(!empty($meta_name) && in_array($meta_name,$current_awards)) {
						$id = it_get_slug($name, $name);
						#award or badge?
						if($badge) { #badge
						
							$out .= $style;
							$out .= '<span class="badge-wrapper';
							if($white) $out .= ' white';
							$out .= ' info" title="' . $name . '"><span class="badge-icon award-icon-' . $id . '"></span></span>';
														   
						} else { #award			
							
							$out .= $style;
							$out .= '<span class="award-wrapper';
							if($white) $out .= ' white';
							$out .= '"><span class="award-icon award-icon-' . $id . '"></span>' . $name . '</span>';	
							
							#exit function if we only need the first item
							$singleout = $wrapper ? $out . '</div>' : $out;
							if($first) return $singleout;	
							
						}
					}
				}
			}
		}
		if($wrapper) $out .= '</div>';
		return $out;	
	}
}
if(!function_exists('it_get_details')) {	
	#html display of the details fields
	function it_get_details($postid, $image, $isreview){
		$out = '';	
		$d = '';
		$flag = false;
		$details = it_get_setting('review_details');
		$badges_hide = it_get_setting('review_badges_hide');
		$details_hide = it_get_setting('review_details_hide');
		$affiliate_position = it_get_setting('affiliate_position');
		if(empty($details)) $details_hide = true;
		$title = it_get_setting('review_details_label');
		$title = ( !empty($title) ) ? $title : __('Overview',IT_TEXTDOMAIN);
		$item_reviewed = get_post_meta($postid, "_item_reviewed", $single = true);
		$item_reviewed = empty($item_reviewed) ? get_the_title() : $item_reviewed;
		$badgesargs = array('postid' => $postid, 'single' => false, 'badge' => true, 'white' => false, 'wrapper' => false);	
		$awardsargs = array('postid' => $postid, 'single' => false, 'badge' => false, 'white' => false, 'wrapper' => false);		
		if($details_hide) return false;	
		#loop through details and add to string
		foreach($details as $detail) {	
			if(is_array($detail)) {
				if(array_key_exists(0, $detail)) {
					$name = $detail[0]->name;	
					if(!empty($name)) { 
						$meta_name = $detail[0]->meta_name; 
						$meta = do_shortcode(wpautop(get_post_meta($postid, $meta_name, $single = true)));
						if(!empty($meta)) {
							$flag = true;
							$d .= '<div class="detail-item">';
								$d .= '<span class="detail-label meta-label">'.$name.'</span>';								
								$d .= '<span class="detail-content">'.$meta.'</span>';
							$d .= '</div>';
						}
					}	
				}
			}
		}
		
		#html output
		if($flag) {
			$badges = it_get_awards($badgesargs);
			$awards = it_get_awards($awardsargs);
			$out .= '<div id="overview-anchor" class="details-box-wrapper clearfix">';
				$out .= '<div class="details-box">';			
					$out .= '<div class="section-title">' . $title . '</div>';				
					$out .= '<div class="details-wrapper">';
					if($affiliate_position=='before-overview') {
						$out .= '<div class="detail-item">';
							$out .= it_get_affiliate_code($postid);
						$out .= '</div>';
					}
					$out .= $d;
					if(!empty($badges)) {
						$out .= '<div class="detail-item">';
							$out .= '<span class="detail-label meta-label">'.__('Badges',IT_TEXTDOMAIN).'</span>';								
							$out .= '<span class="detail-content">'.$badges.'</span>';
						$out .= '</div>';
					}
					if(!empty($awards)) {
						$out .= '<div class="detail-item awards-wrapper">';
							$out .= '<span class="detail-label meta-label">'.__('Awards',IT_TEXTDOMAIN).'</span>';								
							$out .= '<span class="detail-content">'.$awards.'</span>';
						$out .= '</div>';
					}
					if($affiliate_position=='after-overview') {
						$out .= '<div class="detail-item">';
							$out .= it_get_affiliate_code($postid);
						$out .= '</div>';
					}
					$out .= '</div>';					
				$out .= '</div>';
			$out .= '</div>';
		} else {
			$badgesargs['white'] = false;
			$badgesargs['wrapper'] = true;
			$badges = it_get_awards($badgesargs);
			$awardsargs['white'] = false;
			$awardsargs['wrapper'] = true;
			$awards = it_get_awards($awardsargs);
			$out.='<style type="text/css"> #overview-anchor-wrapper {display:none;} </style>';
			if(!empty($awards) || !empty($badges)) $out.='<div class="awards-badges-wrapper">';
			if(!empty($awards)) $out .= $awards;
			if(!empty($badges)) $out .= $badges;
			if(!empty($awards) || !empty($badges)) $out.='</div>';
		}
		
		return $out;	
	}
}
if(!function_exists('it_has_details')) {	
	#returns true if current article has at least one detail
	function it_has_details($postid){		
		$flag = false;
		$details = it_get_setting('review_details');
		$details_hide = it_get_setting('review_details_hide');
		if(empty($details) || $details_hide) return false;	
		#loop through all available details
		foreach($details as $detail) {	
			if(is_array($detail)) {
				if(array_key_exists(0, $detail)) {
					$name = $detail[0]->name;	
					if(!empty($name)) { 
						$meta_name = $detail[0]->meta_name; 
						$meta = get_post_meta($postid, $meta_name, $single = true);
						if(!empty($meta)) {
							$flag = true;							
						}
					}	
				}
			}
		}		
		return $flag;	
	}
}
if(!function_exists('it_get_pros_cons')) {
	#html display of pros and cons
	function it_get_pros_cons($postid) {
		$post_type = get_post_meta( $postid, IT_META_POST_TYPE, $single = true );
		if($post_type=='article') return false;	
		$positives = do_shortcode(wpautop(get_post_meta($postid, IT_META_POSITIVES, $single = true)));	
		$negatives = do_shortcode(wpautop(get_post_meta($postid, IT_META_NEGATIVES, $single = true)));	
		$positives_label = it_get_setting('review_positives_label');
		$negatives_label = it_get_setting('review_negatives_label');
		$positives_label = ( !empty($positives_label) ) ? $positives_label : __('Positives',IT_TEXTDOMAIN);
		$negatives_label = ( !empty($negatives_label) ) ? $negatives_label : __('Negatives',IT_TEXTDOMAIN);	
		$out='';
		if(!empty($positives) || !empty($negatives)) {
			$out.='<div class="procon-box-wrapper clearfix">';
				$out.='<div class="procon-box clearfix">';
					if(!empty($positives)) {
						$out.='<div class="col-wrapper';
						if(empty($negatives)) $out.=' solo';
						$out.='">';
							$out.='<div class="procon pro">';
								$out.='<div class="header section-subtitle">';
									$out.='<span class="theme-icon-plus"></span>';
									$out.=$positives_label;
								$out.='</div>';
								$out.=$positives;
							$out.='</div>';
						$out.='</div>';
					}
					if(!empty($negatives)) {
						$out.='<div class="col-wrapper';
						if(empty($positives)) $out.=' solo';
						$out.='">';
							$out.='<div class="procon con">';
								$out.='<div class="header section-subtitle">';
									$out.='<span class="theme-icon-minus"></span>';
									$out.=$negatives_label;
								$out.='</div>';
								$out.=$negatives;
							$out.='</div>';
						$out.='</div>';
					}
				$out.='</div>';
			$out.='</div>';
		}
		return $out;
	}
}
if(!function_exists('it_get_bottom_line')) {	
	#html display of bottom line
	function it_get_bottom_line($postid) {
		$post_type = get_post_meta( $postid, IT_META_POST_TYPE, $single = true );
		if($post_type=='article') return false;
		$bottomline = do_shortcode(wpautop(get_post_meta($postid, IT_META_BOTTOM_LINE, $single = true)));	
		$bottomline_label = it_get_setting('review_bottomline_label');
		$bottomline_label = ( !empty($bottomline_label) ) ? $bottomline_label : __('Bottom Line',IT_TEXTDOMAIN);
		$out='';
		if(!empty($bottomline)) {
			$out .= '<div class="bottomline">';				
				$out .= '<div class="meta-label">' . $bottomline_label . '</div>';
				$out .= $bottomline;
			$out .= '</div>';
		}
		return $out;
	}
}
if(!function_exists('it_has_rating')) {
	#find out whether or not this article has a rating
	function it_has_rating($postid, $type = 'editor') {
		$post_type = get_post_meta( $postid, IT_META_POST_TYPE, $single = true );
		$rating_override = get_post_meta($postid, IT_META_TOTAL_SCORE_OVERRIDE, $single = true);
		$no_override = true;
		if(!empty($rating_override) && $rating_override!='auto') $no_override = false;
		if($type=='editor') {
			$rating = get_post_meta($postid, IT_META_TOTAL_SCORE, $single = true);
		} else {
			$rating = get_post_meta($postid, IT_META_TOTAL_USER_SCORE, $single = true);
			$no_override = true; #there is no user total score override
		}
		if($post_type=='article' || it_get_setting('review_' . $type . '_rating_disable') || empty($rating) || ($rating=='none' && $no_override)) {
			return false;
		} else {
			return true;
		}
	}
}
if(!function_exists('it_get_rotate')) {
	#get rotation scale for this rating
	function it_get_rotate($postid, $type) {
		$out = array('amount' => 365, 'showfill' => false);
		if($type=='editor') {
			$normalized_rating = get_post_meta($postid, IT_META_TOTAL_SCORE_NORMALIZED, $single = true);
		} else {
			$normalized_rating = get_post_meta($postid, IT_META_TOTAL_USER_SCORE_NORMALIZED, $single = true);
		}
		if($normalized_rating > 50) $out['showfill'] = true;
		$amount = $normalized_rating * 3.6;
		$out['amount'] = $amount . 'deg';
		
		return $out;
	}
}
if(!function_exists('it_show_editor_rating')) {	
	#html display of ratings
	function it_show_editor_rating($args) {
		extract($args);
		
		if(!it_has_rating($postid, 'editor')) return false;
		
		$solo_user = '';
		$solo_editor = '';
		$out = '';
		
		if($single)	$singlecss=" single"; #css class added if this is a single review page
		
		$editor_rating = get_post_meta($postid, IT_META_TOTAL_SCORE, $single = true);
		$editor_rating_override = get_post_meta($postid, IT_META_TOTAL_SCORE_OVERRIDE, $single = true);
		if(!empty($editor_rating_override) && $editor_rating_override!='auto') $editor_rating = $editor_rating_override;
		$editor_rating_hide = it_get_setting('review_editor_rating_hide');	
		
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		
		$meter = $metric=='stars' ? false : $meter;
		
		$deg = array();					
		$deg = it_get_rotate($postid, 'editor');
		$cssfill = $deg['showfill'] ? ' showfill' : '';
		
		$label = $label ? '<div class="rating-label">' . __('Editor',IT_TEXTDOMAIN) . '</div>' : '';
		
		if(!$editor_rating_hide) {	
		
			if($meter) {
		
				$out.='<div class="rating-container">';
												
					$out.='<div class="meter-circle-wrapper">';
			
						$out.='<div class="meter-circle">';
					
							$out.='<div class="meter-wrapper">';
								
								$out.='<div class="meter-slice' . $cssfill . '">';
							
									$out.='<div class="meter" style="-webkit-transform:rotate(' . $deg['amount'] . ');-moz-transform:rotate(' . $deg['amount'] . ');-o-transform:rotate(' . $deg['amount'] . ');-ms-transform:rotate(' . $deg['amount'] . ');transform:rotate(' . $deg['amount'] . ');"></div>';
									
									if($deg['showfill']) $out.='<div class="meter fill" style="-webkit-transform:rotate(' . $deg['amount'] . ');-moz-transform:rotate(' . $deg['amount'] . ');-o-transform:rotate(' . $deg['amount'] . ');-ms-transform:rotate(' . $deg['amount'] . ');transform:rotate(' . $deg['amount'] . ');"></div>';
									
								$out.='</div>';
														
							$out.='</div>';
									
			}
																
			$out .= '<div class="rating editor_rating ' . $metric . '_wrapper">';	
			
				$out .= $label;
				
				$out .= it_get_rating($editor_rating, 'editor', $postid);
							
			$out .= '</div>';			
			
			if($meter) {		
							
						$out.='</div>';
						
					$out.='</div>';
					
				$out.='</div>';
			
			}
			
		}
		
		return $out;
	}
}
if(!function_exists('it_show_user_rating')) {	
	#html display of ratings
	function it_show_user_rating($args) {
		extract($args);
		
		if(!it_has_rating($postid, 'user')) return false;
		
		$solo_user = '';
		
		if($single)	$singlecss=" single"; #css class added if this is a single review page
		
		$user_rating = get_post_meta($postid, IT_META_TOTAL_USER_SCORE, $single = true);
		$user_rating_hide = it_get_setting('review_user_rating_hide');	
		
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;	
		
		$label = $label ? '<div class="rating-label">' . __('User',IT_TEXTDOMAIN) . '</div>' : '';
		
		$out = '<div class="rating user_rating ' . $metric . '_wrapper clearfix">';		
			if(!$user_rating_hide) {
				$out .= $label;
				if($user_icon) $out .= '<span class="theme-icon-users"></span>';
				$out .= it_get_rating($user_rating, 'user', $postid);
			}	
		$out .= '</div>';
		
		return $out;
	}
}
if(!function_exists('it_normalize_value')) {	
	#get normalized value for a rating
	function it_normalize_value($value, $postid) {
		$value = (float) $value;
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		switch ($metric) {
			case 'stars':
				$out = $value * 20;
				break;
			case 'percentage':					
				$out = $value;
				break;
			case 'number':				
				$out = $value * 10;
				break;
			case 'letter':			
				$out = round($value * 7.14285);	
				break;
		}	
		return $out;
	}
}
if(!function_exists('it_get_rating')) {
	#get individual rating
	function it_get_rating($rating, $type, $postid = NULL, $meter = false) {
		$out = '';
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		
		if($meter) {
			
			$deg = array();					
			$deg = it_get_rotate($postid, $type);
			$cssfill = $deg['showfill'] ? ' showfill' : '';
			
			$out.='<div class="rating-container ' . $type . '-container">';
												
				$out.='<div class="meter-circle-wrapper">';
		
					$out.='<div class="meter-circle">';
				
						$out.='<div class="meter-wrapper">';
							
							$out.='<div class="meter-slice' . $cssfill . '">';
						
								$out.='<div class="meter" style="-webkit-transform:rotate(' . $deg['amount'] . ');-moz-transform:rotate(' . $deg['amount'] . ');-o-transform:rotate(' . $deg['amount'] . ');-ms-transform:rotate(' . $deg['amount'] . ');transform:rotate(' . $deg['amount'] . ');"></div>';
								
								if($deg['showfill']) $out.='<div class="meter fill" style="-webkit-transform:rotate(' . $deg['amount'] . ');-moz-transform:rotate(' . $deg['amount'] . ');-o-transform:rotate(' . $deg['amount'] . ');-ms-transform:rotate(' . $deg['amount'] . ');transform:rotate(' . $deg['amount'] . ');"></div>';
								
							$out.='</div>';
													
						$out.='</div>';
						
						$out.='<div class="rating ' . $type . '_rating ' . $metric . '_wrapper">';
		}
		
		switch ($metric) {		
			case 'stars':					
				$out.=it_get_star_rating($rating);
				break;	
			case 'percentage':					
				$out.=it_get_percentage_rating($rating, $type);
				break;
			case 'number':				
				$out.=it_get_number_rating($rating, $type);
				break;
			case 'letter':			
				$out.=it_get_letter_rating($rating, $type);
				break;
		}
		
		if($meter) {
			
						$out.='</div>';		
						
					$out.='</div>';
					
				$out.='</div>';
				
			$out.='</div>';
		
		}			
		
		return $out;
	}
}
if(!function_exists('it_get_star_rating')) {	
	#html for displaying stars
	function it_get_star_rating($rating) {
		#check for acceptable rating value
		if(!is_numeric($rating)) $rating = 0; #if rating is not a number set it to 5
		$valid=false; #default flag
		foreach (range(0, 5, .5) as $num) {
			if($rating == $num) $valid=true; #flag valid value
		}
		if(!$valid) $rating = 0; #valid flag was never set
		$output = '<div class="stars clearfix">';
		$output .= '<span class="theme-icon-star';
		if($rating>=1) {
			$output .= '-full';
		} elseif($rating>0) {
			$output .= '-half';
		}
		$output .= '"></span>';
		$output .= '<span class="theme-icon-star';
		if($rating>=2) {
			$output .= '-full';
		} elseif($rating>1) {
			$output .= '-half';
		}
		$output .= '"></span>';
		$output .= '<span class="theme-icon-star';
		if($rating>=3) {
			$output .= '-full';
		} elseif($rating>2) {
			$output .= '-half';
		}
		$output .= '"></span>';
		$output .= '<span class="theme-icon-star';
		if($rating>=4) {
			$output .= '-full';
		} elseif($rating>3) {
			$output .= '-half';
		}
		$output .= '"></span>';
		$output .= '<span class="theme-icon-star';
		if($rating>=5) {
			$output .= '-full';
		} elseif($rating>4) {
			$output .= '-half';
		}
		$output .= '"></span>';
		$output .= '</div>';
		return $output;
	}
}
if(!function_exists('it_get_percentage_rating')) {	
	#html for displaying percentages
	function it_get_percentage_rating($rating, $type = NULL) {	
		$na = '';
		#check for acceptable rating value
		if(!is_numeric($rating)) {
			$rating = 100; #if rating is not a number set it to 100
			if($type=='user') $na = 'noratings '; #don't display default value for user ratings
		}
		$valid=false; #default flag
		foreach (range(0, 100, 1) as $num) {
			if($rating == $num) $valid=true; #flag valid value
		}
		if(!$valid) $rating = 0; #valid flag was never set	
		$rating .= '<span class="percentage">&#37;</span>';	
		if($na=='noratings ') $rating = '&mdash;';
		#begin html output
		$output = '<div class="number">';
		$output .= $rating;	
		$output .= '</div>';
		return $output;
	}
}
if(!function_exists('it_get_number_rating')) {	
	#html for displaying numbers
	function it_get_number_rating($rating, $type = NULL) {	
		#check for acceptable rating value
		$na = '';
		if(!is_numeric($rating)) {
			$rating = 10; #if rating is not a number set it to 10
			if($type=='user') $na = 'noratings '; #don't display default value for user ratings
		}
		if((!strpos($rating,".") && $rating!=10 && $rating>=.9) || $rating==0) $rating .= ".0"; //add .0 if rating is an even number
		if($na=='noratings ') $rating = '&mdash;';
		//begin html output
		$output = '<div class="number '.$na.'">';
		$output .= $rating;
		$output .= '</div>';
		return $output;
	}
}
if(!function_exists('it_get_letter_rating')) {	
	#html for displaying letter grades
	function it_get_letter_rating($rating, $type = NULL) {
		$na = '';
		#get letter rating in correct format
		$rating = trim(str_replace(" ","",strtoupper($rating)));
		#create array of acceptable values
		$letters = explode(',', IT_LETTER_ARRAY);
		#check for acceptable rating value
		if(!in_array($rating, $letters)) {
			$rating = "A+"; #if rating is not a number set it to A+
			if($type=='user') $na = 'noratings '; #don't display default value for user ratings
		}
		if($na=='noratings ') $rating = '&mdash;';
		//begin html output
		$output = '<div class="letter '.$na.'">';
		$output .= $rating;
		$output .= '</div>';
		return $output;
	}
}
if(!function_exists('it_get_criteria')) {	
	#html display of the rating criteria for use on a single review page
	function it_get_criteria($postid, $image){
		$out='';
		$criteria = it_get_setting('review_criteria');
		$metric = it_get_setting('review_rating_metric');
		$affiliate_position = it_get_setting('affiliate_position');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		$editor_rating_disable = it_get_setting('review_editor_rating_disable');
		$user_rating_disable = it_get_setting('review_user_rating_disable');
		$ratings_header = it_get_setting('review_ratings_header');	
		$editor_header = it_get_setting('review_editor_header');
		$user_header = it_get_setting('review_user_header');
		$top_rating_disable = it_get_setting('review_top_rating_disable');
		$ratings_header = !empty($ratings_header) ? $ratings_header : __('Rating',IT_TEXTDOMAIN);
		$editor_header = !empty($editor_header) ? $editor_header : __('Our Rating',IT_TEXTDOMAIN);
		$user_header = !empty($user_header) ? $user_header : __('User Rating',IT_TEXTDOMAIN);	
		$cssflag = '';
		$cssmetric = ' ' . $metric . '-wrapper';		
		
		$letters=array('A+'=>14,'A'=>13,'A-'=>12,'B+'=>11,'B'=>10,'B-'=>9,'C+'=>8,'C'=>7,'C-'=>6,'D+'=>5,'D'=>4,'D-'=>3,'F+'=>2,'F'=>1);
		$numbers=array(14=>'A+',13=>'A',12=>'A-',11=>'B+',10=>'B',9=>'B-',8=>'C+',7=>'C',6=>'C-',5=>'D+',4=>'D',3=>'D-',2=>'F+',1=>'F');
		
		$total = count($criteria);
		$count = 0;
		$editor_flag = false;
		$user_flag = false;
		$totalnum = 0;
		
		#get the user info
		$ip = it_get_ip();
		$userid = get_current_user_id();
		$noanon = it_get_setting('review_registered_user_ratings');				
		
		$post_type = get_post_meta( $postid, IT_META_POST_TYPE, $single = true );	
		$total_value = get_post_meta($postid, IT_META_TOTAL_SCORE, $single = true);
		$total_value_normalized = get_post_meta( $postid, IT_META_TOTAL_SCORE_NORMALIZED, $single = true );
		$editor_rating_override = get_post_meta($postid, IT_META_TOTAL_SCORE_OVERRIDE, $single = true);
		
		if((empty($editor_rating_override) || $editor_rating_override=='auto') && (empty($total_value) || $total_value=='none')) $editor_rating_disable = true;
		
		#display the pros and cons first
		$out.=it_get_pros_cons($postid);
		
		#see if this post has any editor or user ratings to display
		if($total > 1) {
			foreach($criteria as $criterion) {
				if(is_array($criterion)) {
					if(array_key_exists(0, $criterion)) {
									
						$meta_name = $criterion[0]->meta_name;						
						$value = get_post_meta($postid, $meta_name, $single = true);						
						if(!empty($value) && $value!='none') {							
							if(!$editor_rating_disable) {								
								if($value!='user') {
									$editor_flag = true;
								}								
							}
							if(!$user_rating_disable) {
								$user_flag = true;
							}
						}
						
					}
				}
			}
		}
		if(!$editor_flag) $editor_rating_disable = true;
		if(!$user_flag) $user_rating_disable = true;
		
		$cssuser = $editor_rating_disable ? $cssuser = 6 : $cssuser = 3;
		$csseditor = $user_rating_disable ? $csseditor = 6 : $csseditor = 3;
		$cssuserxs = $cssuser * 2;
		$csseditorxs = $csseditor * 2;		
		$csssolo = $editor_rating_disable || $user_rating_disable ? $csssolo = ' solo' : '';
		
		if(($editor_rating_disable && $user_rating_disable) || $post_type=='article') {
			
			$out.='<style type="text/css"> #rating-anchor-wrapper {display:none;} </style>';
			
		} else {
			
			$out.='<div id="rating-anchor" class="ratings clearfix' . $cssmetric . $csssolo . '">';
			
				#HEADER ROW
				$out.='<div class="row">';
				
					$out.='<div class="col-md-6 col-xs-6">';
						$out.='<div class="section-title">' . $ratings_header . '</div>';
					$out.='</div>';
					
					if(!$editor_rating_disable) {
					
						$out.='<div class="col-md-'.$csseditor.' col-xs-'.$csseditor.'">';
							$out.='<div class="editor-header section-subtitle"><span class="theme-icon-reviewed"></span>' . $editor_header . '</div>';
						$out.='</div>';
						
					}
					
					if(!$user_rating_disable) {
						
						$out.='<div class="col-md-'.$cssuser.' col-xs-'.$cssuser.'">';
							$out.='<div class="user-header section-subtitle"><span class="theme-icon-users"></span>' . $user_header . '</div>';
							if(!$top_rating_disable) $out.='<div class="hovertorate"><span class="hover-text">'.__('Rate Here',IT_TEXTDOMAIN).'</span><span class="theme-icon-down-fat"></span></div>';
						$out.='</div>';
						
					}
						
				$out.='</div>';
				
				$out.='<div class="row">';
				
					$out.='<div class="col-md-12">';
				
						$out.='<div class="rating-criteria">';
					
							#CRITERIA ROWS							
							foreach($criteria as $criterion) {
								if(is_array($criterion)) {
									if(array_key_exists(0, $criterion)) {
											
										$name = $criterion[0]->name;
										$meta_name = $criterion[0]->meta_name;
										
										$value = get_post_meta($postid, $meta_name, $single = true);
										
										if(!empty($value) && $value!='none') {	
										
											$out.='<div class="row">';
											
												$out.='<div class="col-md-12"><div class="rating-line"></div></div>';
											
												$out.='<div class="col-md-6 col-xs-6">';
											
													#label
													$out.='<div class="rating-label meta-label">'.$name.'</div>';
													
												$out.='</div>';
						
												#editor rating
												if(!$editor_rating_disable) {
													
													$out.='<div class="col-md-'.$csseditor.' col-xs-'.$csseditor.'">';
														
														$out.='<div class="ratings-panel editor-rating">';
															$id = 'editor_rating_'.$count;										
															
															if($value!='user') {							
																#get number value of letter grade
																if ($metric=='letter') $value=$letters[$value];
																$value_normalized = it_normalize_value($value, $postid);
																#turn number back into letter for display
																if ($metric=='letter') $value=$numbers[$value];
																if(!empty($name)) {																		
																	$out.='<div class="rating-wrapper" id="'.$id.'">';	
																		$out.='<div class="rating-value-wrapper">';														
																			$out.='<div class="rating-value">'.it_get_rating($value, 'editor', $postid).'</div>';
																		$out.='</div>';
																	$out.='</div>';													
																}
															}
															
														$out.='</div>';
														
													$out.='</div>';
														
												}	
											
												#user rating
												if(!$user_rating_disable) {	
												
													$out.='<div class="col-md-'.$cssuser.' col-xs-'.$cssuser.'">';									
													
														$out.='<div class="ratings-panel user-rating">';											
															$id = 'user_rating_'.$count;																
															$meta_name = $meta_name.'_user';
															$value = get_post_meta($postid, $meta_name, $single = true);
															
															if(it_get_setting('review_user_ratings_new')) {
																#get existing user ratings
																$ratings = get_post_meta($postid, $meta_name.'_ratings', $single = true);
																$ratings = substr_replace($ratings,'',-1);
																$ratings = !empty($ratings) ? explode(';',$ratings) : array();																
																#determine if new rating or edit
																$changing = false;
																$chk = $noanon ? $userid : $ip;
																foreach($ratings as $pair) {
																	$arr = explode(',',$pair);
																	$id = $arr[0];
																	$existing = $arr[1];
																	if($id==$chk) {
																		$changing = true;				
																		break;
																	}
																}
																$num = count($ratings);																
																$totalnum += $num;															
																#check and see if user has already rated this criteria
																$cssactive = '';
																$readonly = 'false';
																$cssrateable = ' rateable';
																if($changing && !it_get_setting('rating_limit_disable')) {
																	$cssflag = ' active';
																	$cssactive = ' active';
																}																	
															} else {
																$ips = get_post_meta($postid, $meta_name.'_ips', $single = true);
																$ips = substr_replace($ips,"",-1);
																$ids = get_post_meta($postid, $meta_name.'_ids', $single = true);
																$ids = substr_replace($ids,"",-1);
																$existing = $noanon ? $ids : $ips;
																$chk = $noanon ? $userid : $ip;
																$numarr = !empty($existing) ? explode(';',$existing) : array();
																$num = count($numarr);																
																$totalnum += $num;															
																#check and see if user has already rated this criteria
																$cssactive = '';
																$readonly = 'false';
																$cssrateable = ' rateable';
																if(in_array($chk,$numarr) && !it_get_setting('rating_limit_disable')) {
																	$cssflag = ' active';
																	$cssactive = ' active';
																	$readonly = 'true';
																	$cssrateable = '';
																}	
															}
															if($top_rating_disable) $readonly = 'true';
															$cssrateable = $metric=='stars' ? '' : $cssrateable;															
															#get number value of letter grade
															if ($metric=='letter') $value=$letters[$value];
															$value_normalized = it_normalize_value($value, $postid);
															#turn number back into letter for display
															if ($metric=='letter') $value=$numbers[$value];
															#get type of rating to display
															if (it_get_setting('rating_limit_disable') || it_get_setting('review_user_ratings_new')) {
																$unlimitedratings = 1;
															}
															if ($metric=='stars') {
																$rating_value = '<div class="rateit" data-rateit-starwidth="16" data-rateit-starheight="16" data-rateit-resetable="false" data-rateit-value="'.$value.'" data-rateit-ispreset="true" data-postid="'.$postid.'" data-rateit-readonly="'.$readonly.'" data-meta="'.$meta_name.'" data-unlimitedratings="'.$unlimitedratings.'"></div>';
																$rating_value .= '<div class="rateit mobile" data-rateit-starwidth="10" data-rateit-starheight="10" data-rateit-resetable="false" data-rateit-value="'.$value.'" data-rateit-ispreset="true" data-postid="'.$postid.'" data-rateit-readonly="'.$readonly.'" data-meta="'.$meta_name.'" data-unlimitedratings="'.$unlimitedratings.'"></div>';
															} else {
																$rating_value = it_get_rating($value, 'user', $postid);
															}
															if(!empty($name)) {
																$out.='<div id="'.$id.'_wrapper" class="rating-wrapper'.$cssactive.$cssrateable.'" onclick = "void(0)">';
																	$out.='<div id="'.$id.'" data-meta="'.$meta_name.'" data-postid="'.$postid.'" data-metric="'.$metric.'">';															
																		$out.='<div class="theme-icon-check"></div>';
																		$out.='<div class="rating-value-wrapper">';
																			$out.='<div class="rating-value">'.$rating_value.'</div>';
																			$out.='<div class="form-selector-wrapper"><div class="form-selector"></div></div>';
																		$out.='</div>';																			
																	$out.='</div>';
																$out.='</div>';																	
															}
														$out.='</div>';															
													$out.='</div>';	
												}
												
											$out.='</div>';
											$count++;	
										}	
									}
								}
							}
						$out.='</div>';
					$out.='</div>';
				$out.='</div>';
					
				#TOTAL ROW
				$out.='<div class="row">';
				
					$out.='<div class="col-md-12">';
					
						$out.='<div class="total-wrapper clearfix">';
							
							$out.='<div class="total-info">';
							
								$out.='<div class="row">';
						
									$out.='<div class="col-md-6 col-sm-6">';
									
										$out.=it_get_bottom_line($postid);
										
										if($affiliate_position=='rating') $out .= it_get_affiliate_code($postid);
										
									$out.='</div>';
									
									if(!$editor_rating_disable) {
										
										$out.='<div class="col-md-'.$csseditor.' col-sm-'.$csseditor.' col-xs-'.$csseditorxs.' total-rating-wrapper">';
											#editor total
											if(!empty($editor_rating_override) && $editor_rating_override!='auto') $total_value = $editor_rating_override;
											$out.='<div class="rating-wrapper total" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">';
												$out.='<meta itemprop="worstRating" content="0">';
												if($metric=='stars') $out.='<meta itemprop="ratingValue" content="'.$total_value.'" />';
												if($metric=='letter') $out.='<meta itemprop="ratingValue" content="'.$total_value_normalized.'" />';
												$out.='<div class="total-rating-value large-meter"';
												#different display for letters since they use normalized values
												#i.e. display one value but show google rich snippets another
												if($metric!='letter' && $metric!='stars') $out.=' itemprop="ratingValue"';
												$out.='>'.it_get_rating($total_value, 'editor', $postid, true).'</div>';
												$out.='<meta itemprop="bestRating" content="'.it_get_best_rating($postid).'">';
												$out.='<div class="section-subtitle">' . $editor_header . '</div>';
											$out.='</div>';											
										$out.='</div>';
										
									}
									
									if(!$user_rating_disable) {
									
										$out.='<div class="col-md-'.$cssuser.' col-sm-'.$cssuser.' col-xs-'.$cssuserxs.' total-rating-wrapper">';
											#user total
											#avoid divide by 0
											if($count==0) $count = 1;
											#determine number of user ratings						
											$numratings = round($totalnum / $count, 0);						
											$numlabel = __(' ratings',IT_TEXTDOMAIN);
											if($numratings==1) $numlabel = __(' rating',IT_TEXTDOMAIN);	
											$value = get_post_meta($postid, IT_META_TOTAL_USER_SCORE, $single = true);
											$out.='<div class="rating-wrapper total" data-numratings="'.$numratings.'">';								
												$out.='<div class="total-rating-value large-meter">'.it_get_rating($value, 'user', $postid, true).'</div>';
												$out.='<div class="section-subtitle">' . $user_header . '</div>';
												if(!it_get_setting('review_user_ratings_number_disable') && $numratings > 0) $out.='<div class="rating-number"><span class="value">' . $numratings . '</span>' . $numlabel . '</div>';
											$out.='</div>';											
											
										$out.='</div>';
										
									}
									
								$out.='</div>';	
								
								$out.='<div class="rated-legend'.$cssflag.'"><span class="theme-icon-check"></span>'.__('You have rated this',IT_TEXTDOMAIN).'</div>';
								
							$out.='</div>';	
							
						$out.='</div>';
						
					$out.='</div>';
					
				$out.='</div>';
				
			$out.='</div>';
			
		}
	
		return $out;
	}
}
if(!function_exists('it_get_comment_criteria')) {	
	#html display of the rating criteria for use on in the comment area
	function it_get_comment_criteria($postid){
		$criteria = it_get_setting('review_criteria');
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
				
		$letters=array('A+'=>14,'A'=>13,'A-'=>12,'B+'=>11,'B'=>10,'B-'=>9,'C+'=>8,'C'=>7,'C-'=>6,'D+'=>5,'D'=>4,'D-'=>3,'F+'=>2,'F'=>1);
		$numbers=array(14=>'A+',13=>'A',12=>'A-',11=>'B+',10=>'B',9=>'B-',8=>'C+',7=>'C',6=>'C-',5=>'D+',4=>'D',3=>'D-',2=>'F+',1=>'F');
		
		$out='';
		$count=0;
		$totalnum=0;
		$flag=false;
		
		#get the user info
		$ip = it_get_ip();
		$userid = get_current_user_id();
		$noanon = it_get_setting('review_registered_user_ratings');
		
		foreach($criteria as $criterion) {
			if(is_array($criterion)) {
				if(array_key_exists(0, $criterion)) {
					$id = 'user_comment_rating_'.$count;
					$name = $criterion[0]->name;
					$meta_name = $criterion[0]->meta_name.'_user';
					$meta_name_editor = $criterion[0]->meta_name;
					$value = get_post_meta($postid, $meta_name, $single = true);
					$value_editor = get_post_meta($postid, $meta_name_editor, $single = true);
					
					if((!empty($value_editor) && $value_editor!='none') || $value_editor=='user') {	
					
						if(it_get_setting('review_user_ratings_new')) {
							
							#get existing user ratings
							$ratings = get_post_meta($postid, $meta_name.'_ratings', $single = true);
							$ratings = substr_replace($ratings,'',-1);
							$ratings = !empty($ratings) ? explode(';',$ratings) : array();																
							#determine if new rating or edit
							$changing = false;
							$chk = $noanon ? $userid : $ip;
							foreach($ratings as $pair) {
								$arr = explode(',',$pair);
								$id = $arr[0];
								$existing = $arr[1];
								if($id==$chk) {
									$changing = true;				
									break;
								}
							}
							$num = count($ratings);																
							$totalnum += $num;															
							#check and see if user has already rated this criteria
							$cssactive = '';
							$readonly = 'false';
							$cssrateable = (!$noanon || is_user_logged_in()) && $metric!='stars' ? ' rateable' : '';
							if($changing && !it_get_setting('rating_limit_disable')) {
								$cssflag = ' active';
								$cssactive = ' active';
								$readonly = 'true';
								$cssrateable = ' rated';
							}
							
						} else {
					
							$ips = get_post_meta($postid, $meta_name.'_ips', $single = true);
							$ips = substr_replace($ips,"",-1);
							$ids = get_post_meta($postid, $meta_name.'_ids', $single = true);
							$ids = substr_replace($ids,"",-1);
							$existing = $noanon ? $ids : $ips;
							$chk = $noanon ? $userid : $ip;
							$numarr = !empty($existing) ? explode(';',$existing) : array();
							$num = count($numarr);
							#check and see if user has already rated this criteria
							$cssactive = '';
							$readonly = 'false';
							$cssrateable = $metric=='stars' ? '' : ' rateable';
							if(in_array($chk,$numarr) && !it_get_setting('rating_limit_disable')) {
								$cssflag = ' active';
								$cssactive = ' active';
								$readonly = 'true';
								$cssrateable = ' rated';
							}
						}
						#get number value of letter grade
						if ($metric=='letter') $value=$letters[$value];
						$value_normalized = it_normalize_value($value, $postid);
						#turn number back into letter for display
						if ($metric=='letter') $value=$numbers[$value];
						#get type of rating to display
						if (it_get_setting('rating_limit_disable')) {
							$unlimitedratings = 1;
						}
						if ($metric=='stars') {
							$rating_value = '<div class="rateit" data-rateit-starwidth="16" data-rateit-starheight="16" data-rateit-resetable="false" data-rateit-ispreset="true" data-postid="'.$postid.'" data-rateit-readonly="'.$readonly.'" data-meta="'.$meta_name.'" data-unlimitedratings="'.$unlimitedratings.'" data-noupdate="1"></div>';
							$rating_value .= '<div class="rateit mobile" data-rateit-starwidth="10" data-rateit-starheight="10" data-rateit-resetable="false" data-rateit-ispreset="true" data-postid="'.$postid.'" data-rateit-readonly="'.$readonly.'" data-meta="'.$meta_name.'" data-unlimitedratings="'.$unlimitedratings.'" data-noupdate="1"></div>';
						} else {
							if($readonly == 'true') {
								$rating_value = it_get_rating($value, 'user', $postid);
							} else {
								$rating_value = '&mdash;';
							}
						}
						if(!empty($name)) {
							$out.='<div id="'.$id.'_wrapper" class="rating-wrapper clearfix'.$cssactive.$cssrateable.'" onclick = "void(0)">';
								$out.='<div id="'.$id.'" data-meta="'.$meta_name.'" data-postid="'.$postid.'" data-metric="'.$metric.'">';															
									$out.='<div class="theme-icon-check"></div>';
									$out.='<div class="rating-label meta-label">'.$name.'</div>';
									$out.='<div class="rating-value-wrapper">';
										$out.='<div class="rating-value">'.$rating_value.'</div>';
										$out.='<div class="form-selector-wrapper"><div class="form-selector"></div></div>';
									$out.='</div>';	
									$out.='<input type="hidden" class="hidden-rating-value" name="'.$meta_name.'" />';																		
								$out.='</div>';							
							$out.='</div>';						
							$count++;
						}
					}
				}
			}
		}		
		$out.='<input type="hidden" id="comment-metric" value="'. $metric .'" />';
		
		#if pros/cons are enabled and user is not in the post meta, display the comment fields
		if(!it_get_setting('review_user_comment_procon_disable')) {
			$pros_ips = get_post_meta($postid, IT_META_USER_PROS_IP_LIST, $single = true);
			$cons_ips = get_post_meta($postid, IT_META_USER_CONS_IP_LIST, $single = true);
			$pros_ids = get_post_meta($postid, IT_META_USER_PROS_ID_LIST, $single = true);
			$cons_ids = get_post_meta($postid, IT_META_USER_CONS_ID_LIST, $single = true);
			$pros_existing = $noanon ? explode(';',$pros_ids) : explode(';',$pros_ips);
			$cons_existing = $noanon ? explode(';',$cons_ids) : explode(';',$cons_ips);
			$chk = $noanon ? $userid : $ip;
			$pros_label = it_get_setting('review_positives_label');
			$cons_label = it_get_setting('review_negatives_label');
			$pros_label = ( !empty($pros_label) ) ? $pros_label : __('Positives',IT_TEXTDOMAIN);
			$cons_label = ( !empty($cons_label) ) ? $cons_label : __('Negatives',IT_TEXTDOMAIN);	
			if(!in_array($chk,$pros_existing) || it_get_setting('rating_limit_disable')) {
				$out .= '<textarea name="comment-pros" class="form-control comment-pros" aria-required="true" rows="4" placeholder="'.$pros_label.'"></textarea>';
			} else {
				$out.='<div class="rating-wrapper active clearfix">';
					$out.='<div class="rating-label">'.$pros_label.'</div>';
					$out.='<div class="theme-icon-check"></div>';
				$out.='</div>';	
				$flag = true;
			}
			if(!in_array($chk,$cons_existing) || it_get_setting('rating_limit_disable')) {
				$out .= '<textarea name="comment-cons" class="form-control comment-cons" aria-required="true" rows="4" placeholder="'.$cons_label.'"></textarea>';
			} else {
				$out.='<div class="rating-wrapper active clearfix">';
					$out.='<div class="rating-label">'.$cons_label.'</div>';
					$out.='<div class="theme-icon-check"></div>';
				$out.='</div>';	
				$flag = true;	
			}
		}	
		if($flag) $out.='<div class="rated-legend active"><span class="theme-icon-check"></span>'.__('saved',IT_TEXTDOMAIN).'</div>';
		
		return $out;
	}
}
if(!function_exists('it_get_comment_rating')) {	
	#html display of user's ratings within comment list
	function it_get_comment_rating($postid, $commentid) {
		$out = '';
		$post_type = get_post_meta( $postid, IT_META_POST_TYPE, $single = true );
		if($post_type=='article') return false;
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;
		$numbers=array(14=>'A+',13=>'A',12=>'A-',11=>'B+',10=>'B',9=>'B-',8=>'C+',7=>'C',6=>'C-',5=>'D+',4=>'D',3=>'D-',2=>'F+',1=>'F');
		$overlay_image = wp_get_attachment_image_src( get_post_thumbnail_id($postid), 'large' );
		if(!it_get_setting('review_user_rating_disable')) {
			#get pros/cons
			if(!it_get_setting('review_user_comment_procon_disable')) {
				$positives_label = it_get_setting('review_positives_label');
				$negatives_label = it_get_setting('review_negatives_label');
				$positives_label = ( !empty($positives_label) ) ? $positives_label : __('Positives',IT_TEXTDOMAIN);
				$negatives_label = ( !empty($negatives_label) ) ? $negatives_label : __('Negatives',IT_TEXTDOMAIN);					
				$pros = wpautop(get_comment_meta($commentid, 'user_pros', true));
				$cons = wpautop(get_comment_meta($commentid, 'user_cons', true));
			}
			#get ratings
			if(!it_get_setting('review_user_comment_rating_disable')) {
				$criteria = it_get_setting('review_criteria');
				$ratings = array();
				foreach($criteria as $criterion) {
					if(is_array($criterion)) {
						if(array_key_exists(0, $criterion)) {
							$meta_name = $criterion[0]->meta_name.'_user';
							$name = $criterion[0]->name;
							$rating = get_comment_meta($commentid, $meta_name, true);
							#get letter value for letter ratings
							if($metric=='letter') $rating = $numbers[$rating];
							if(!empty($rating)) $ratings[$name] = $rating;
						}
					}
				}
			}
			if(!empty($pros) || !empty($cons) || !empty($ratings)) {
				$out .= '<div class="comment-rating">';
					$out .= '<div class="comment-rating-inner clearfix">';
						if(!empty($pros)) {	
							$out.='<div class="comment-procon-wrapper">';				
								$out.='<div class="section-subtitle">';
									$out.='<span class="theme-icon-plus"></span>';
									$out.=$positives_label;
								$out.='</div>';
								$out.=$pros;
							$out.='</div>';					
						}
						if(!empty($cons)) {
							$out.='<div class="comment-procon-wrapper">';				
								$out.='<div class="section-subtitle">';
									$out.='<span class="theme-icon-minus"></span>';
									$out.=$negatives_label;
								$out.='</div>';
								$out.=$cons;
							$out.='</div>';		
						}
						if(!empty($ratings)) {
							$out.='<div class="comment-procon-wrapper">';				
								$out.='<div class="section-subtitle">';
									$out.='<span class="theme-icon-reviewed"></span>';
									$out.=__('Rating',IT_TEXTDOMAIN);
								$out.='</div>';
								foreach($ratings as $key => $value) {
									if($metric=='stars') {
										$value = it_get_rating($value, 'editor', $postid);
									}
									$out.='<div class="rating-wrapper clearfix ' . $metric . '">';
										$out.='<span class="rating">'.$key.'</span>';
										$out.='<span class="value">'.$value.'</span>';
									$out.='</div>';
								}
							$out.='</div>';						
						}
					$out .= '</div>';
				$out .= '</div>';
			}
		}
		return $out;
	}
}
if(!function_exists('it_save_comment_meta')) {	
	function it_save_comment_meta($comment_id) {
		global $post;
		#setup variables
		$pros=wp_filter_nohtml_kses($_POST['comment-pros']);
		$cons=wp_filter_nohtml_kses($_POST['comment-cons']);
		$criteria = it_get_setting('review_criteria');
		$metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($post->ID, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $metric = $metric_meta;	
		$flag = false;
		$letters=array('A+'=>14,'A'=>13,'A-'=>12,'B+'=>11,'B'=>10,'B-'=>9,'C+'=>8,'C'=>7,'C-'=>6,'D+'=>5,'D'=>4,'D-'=>3,'F+'=>2,'F'=>1);
		#get the user info
		$ip = it_get_ip();
		$userid = get_current_user_id();
		$noanon = it_get_setting('review_registered_user_ratings');
		
		if(!it_get_setting('review_user_rating_disable')) {
			#save pros/cons
			if(!it_get_setting('review_user_comment_procon_disable')) {
				if(!empty($pros)) {
					$flag = true;
					add_comment_meta( $comment_id, 'user_pros', $pros );	
					#update post meta for use in display of pro/con comment meta fields
					$ips = get_post_meta($post->ID, IT_META_USER_PROS_IP_LIST, $single = true);	
					#add ip to string
					$ips.=$ip.';';
					update_post_meta($post->ID, IT_META_USER_PROS_IP_LIST, $ips);
					if($noanon) {
						#also update list of user ids
						$ids = get_post_meta($post->ID, IT_META_USER_PROS_ID_LIST, $single = true);	
						#add id to string
						$ids.=$userid.';';
						update_post_meta($post->ID, IT_META_USER_PROS_ID_LIST, $ids);	
					}
							
				}
				if(!empty($cons)) {
					$flag = true;
					add_comment_meta( $comment_id, 'user_cons', $cons );	
					#update post meta for use in display of pro/con comment meta fields
					$ips = get_post_meta($post->ID, IT_META_USER_CONS_IP_LIST, $single = true);	
					#add ip to string
					$ips.=$ip.';';
					update_post_meta($post->ID, IT_META_USER_CONS_IP_LIST, $ips);
					if($noanon) {
						#also update list of user ids
						$ids = get_post_meta($post->ID, IT_META_USER_CONS_ID_LIST, $single = true);	
						#add id to string
						$ids.=$userid.';';
						update_post_meta($post->ID, IT_META_USER_CONS_ID_LIST, $ids);	
					}
									
				}
			}
			#save ratings
			if(!it_get_setting('review_user_comment_rating_disable')) {
				foreach($criteria as $criterion) {
					$meta_name = $criterion[0]->meta_name.'_user';
					$rating = wp_filter_nohtml_kses($_POST[$meta_name]);
					//die('meta_name = ' . $meta_name . ', rating = ' . $rating);
					#get number value for letter ratings
					if($metric=='letter') $rating = $letters[$rating];
					
					if(!empty($rating)) {
						
						#trip flag
						$flag = true;
					
						#setup the args
						$ratingargs = array('postid' => $post->ID, 'meta' => $meta_name, 'metric' => $metric, 'rating' => $rating);
						
						#perform the actual meta updates
						$ratings = it_save_user_ratings($ratingargs);
						
						#add to comment meta
						add_comment_meta( $comment_id, $meta_name, $rating );
						
					}
					
				}
			}
			#if there is not at least one meta value, delete the comment
			if(!$flag) {
				$val = rand(0, 384534);
				if(strpos($_POST['comment'],'it_hide_this_comment')>0) wp_delete_comment( $comment_id, true );
			}
		}
	}
}
if(!function_exists('it_save_user_ratings')) {	
	#loops through rating criteria and updates custom fields
	function it_save_user_ratings($args) {
		
		#get the user info
		$ip = it_get_ip();
		$userid = get_current_user_id();
		$noanon = it_get_setting('review_registered_user_ratings');
		$existing = '';
		$sum = 0;
		$letters=array('A+'=>14,'A'=>13,'A-'=>12,'B+'=>11,'B'=>10,'B-'=>9,'C+'=>8,'C'=>7,'C-'=>6,'D+'=>5,'D'=>4,'D-'=>3,'F+'=>2,'F'=>1);
		$numbers=array(14=>'A+',13=>'A',12=>'A-',11=>'B+',10=>'B',9=>'B-',8=>'C+',7=>'C',6=>'C-',5=>'D+',4=>'D',3=>'D-',2=>'F+',1=>'F');
		
		#get passed array into variables
		extract($args);	
		
		if(it_get_setting('review_user_ratings_new')) {
			#get existing user ratings
			$ratings = get_post_meta($postid, $meta.'_ratings', $single = true);
			$ratings = substr_replace($ratings,'',-1);
			$ratings = !empty($ratings) ? explode(';',$ratings) : array();
			
			#determine if new rating or edit
			$changing = false;
			$chk = $noanon ? $userid : $ip;
			foreach($ratings as $pair) {
				$arr = explode(',',$pair);
				$id = $arr[0];
				$existing = $arr[1];
				if($id==$chk) {
					$changing = true;				
					break;
				}
			}
			
			#current id with old rating value
			$oldpair = is_null($existing) ? '' : $chk . ',' . $existing;
				
			#remove old pair from meta value
			if(($key = array_search($oldpair, $ratings)) !== false && !it_get_setting('rating_limit_disable')) unset($ratings[$key]);		
					
			#current id with new rating value		
			$newpair = $chk . ',' . $rating . ';';	
			$ratings = empty($ratings) ? $newpair : implode(';', $ratings) . ';' . $newpair;				
			#update meta value
			update_post_meta($postid, $meta.'_ratings', $ratings);
				
			#get new user rating
			$ratings = substr_replace($ratings,'',-1);
			$ratings = !empty($ratings) ? explode(';',$ratings) : array();
			foreach($ratings as $pair) {
				$arr = explode(',',$pair);
				$id = $arr[0];
				$existing = $arr[1];
				$sum += $existing;
			}				
			$count = count($ratings);
			
		} else {
		
			#ip/id list meta fields
			$ips = get_post_meta($postid, $meta.'_ips', $single = true);
			$ids = get_post_meta($postid, $meta.'_ids', $single = true);
		
			#add ip/id to string
			$ips.=$ip.';';
			$ids.=$userid.';';
			
			#update ip/id meta
			update_post_meta($postid, $meta.'_ips', $ips);
			if($noanon) update_post_meta($postid, $meta.'_ids', $ids);
			
			#rating list meta field
			$ratings = get_post_meta($postid, $meta.'_ratings', $single = true);
		
			#add rating to string
			$ratings.=$rating.';';
			
			#update rating meta
			update_post_meta($postid, $meta.'_ratings', $ratings);
					
			#get new user rating
			$ratings = substr_replace($ratings,"",-1);
			$arr = explode(";",$ratings);
			$sum = array_sum($arr);
			$count = count($arr);			
		}
		
		$precision = 1;
		if($metric=='percentage') $precision = 0;
		if(empty($count)) $count = 1;
		$new_rating = round($sum / $count, $precision);
		
		if($metric=='letter') $new_rating = $numbers[$new_rating];		
		
		#user rating meta field
		$rating_meta = get_post_meta($postid, $meta, $single = true);		
				
		update_post_meta($postid, $meta, $new_rating);
		
		#get individual normalized value to pass back to ajax
		$normalized = it_normalize_value($new_rating, $postid);
		
		#get updated total user score
		$criteria = it_get_setting('review_criteria');	
		$sum_ratings=0;
		if(!empty($criteria)) {	#loop thru criteria
			foreach($criteria as $criterion) { 
				$meta_name = $criterion[0]->meta_name.'_user'; 
				$w = $criterion[0]->weight;				
				#get criteria rating
				$r = get_post_meta($postid, $meta_name, $single = true);
				if(($r!='none' && !empty($r)) || $r=='0') {
					# different averaging method for letter grades
					if ($metric=="letter") $r=$letters[$r];
					# set default weight if non-existent or invalid
					if(!is_numeric($w)) $w=1;	
					# increase total score	
					$sum_ratings += (float) $r * $w;
					# increase total weight
					$sum_weights += $w;
				}
			} 		
			# get averaged total
			$total_rating = $sum_ratings / $sum_weights;
			# different rounding based on metric
			switch ($metric) {
				case 'stars':
					$total_rating = round($total_rating * 2) / 2; # need to get an even .5 rating for stars
					break;
				case 'percentage':
					$total_rating = round($total_rating, $precision); # round to the closest whole number
					break;
				case 'number':
					$total_rating = round($total_rating, $precision); # round to the closest decimal point (tenth place)
					break;
				case 'letter':
					$total_rating = round($total_rating); # round to the closest whole number
					break;
			}
			$rating_normalized = it_normalize_value($total_rating, $postid);
			if($metric=='letter') $total_rating = $numbers[$total_rating]; # turn the rating number back into a letter	
		} 
		
		#update auto score
		update_post_meta( $postid, IT_META_TOTAL_USER_SCORE, $total_rating );
			
		#update normalized score (for use in cross-type sorting)
		update_post_meta( $postid, IT_META_TOTAL_USER_SCORE_NORMALIZED, $rating_normalized );
		
		#get updated total user score
		if($metric=='stars') $total_rating = it_get_rating($total_rating, 'user', $postid);
		
		#add percentages if needed
		if($metric=='percentage') {
			$new_rating .= '<span class="percentage">&#37;</span>';
			$total_rating .= '<span class="percentage">&#37;</span>';			
		}
		
		#should ratings become disabled
		$unlimitedratings = 0;
		if(it_get_setting('rating_limit_disable') || it_get_setting('review_user_ratings_new')) $unlimitedratings = 1;
		
		#update meter circle
		$deg = array();					
		$deg = it_get_rotate($postid, 'user');
		$cssfill = $deg['showfill'] ? 'showfill' : '';
		$amount = !empty($deg['amount']) ? $deg['amount'] : '';
		
		return array('new_rating' => $new_rating, 'total_rating' => $total_rating, 'normalized' => $normalized, 'unlimitedratings' => $unlimitedratings, 'cssfill' => $cssfill, 'amount' => $amount);
	}
}
?>