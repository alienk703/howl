<?php
/**
 *
 */
class itMetaBox extends itOptionGenerator {
	
	private $_meta_box;
	
	/**
	 *
	 */
	function __construct( $meta_box ) {
		
		if ( !is_admin() ) return;
		
		$this->_meta_box = $meta_box;
		
		add_action( 'admin_menu', array( &$this, 'add' ) );
		add_action( 'save_post', array( &$this, 'save' ) );
	}
	
	/**
	 *
	 */
	function add() {
		foreach ( $this->_meta_box['pages'] as $page ) {
			add_meta_box( $this->_meta_box['id'], $this->_meta_box['title'], array( &$this, 'show' ), $page, $this->_meta_box['context'], $this->_meta_box['priority'] );
		}
	}
	
	/**
	 *
	 */
	function show() {
		global $post;
		
		$out = '';
		
		foreach ( $this->_meta_box['fields'] as $value ) {
			$meta = get_post_meta( $post->ID, $value['id'], true );			
			if(@unserialize($meta)) $meta = @unserialize($meta);
			
			if ( $meta != '' ) 
				$value['default'] = $meta;
				
			$value['postid'] = $post->ID;
				
			$out .= $this->$value['type']( $value );
		}
		
		# Use nonce for verification
		$out .= '<input type="hidden" name="' . $this->_meta_box['id'] . '_meta_box_nonce" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';
		
		echo $out;
	}
	
	
	/**
	 *
	 */
	function save( $post_id ) {
		# check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		
		if( empty( $_POST[$this->_meta_box['id'] . '_meta_box_nonce'] ) )
			return $post_id;
		
		# verify nonce
		if ( !wp_verify_nonce( $_POST[$this->_meta_box['id'] . '_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}

		# check permissions
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		
		# save the meta boxes
		foreach ( $this->_meta_box['fields'] as $value ) {
			$name = $value['id'];
			
			$old = get_post_meta( $post_id, $name, true );
			
			$new = ( !empty( $_POST[IT_SETTINGS][$value['id']] ) )
			? $_POST[IT_SETTINGS][$value['id']]
			: '';
			
			if(is_array($new)) $new = serialize($new);
						
			if ( $new && $new != $old ) {
				update_post_meta( $post_id, $name, $new );
			} elseif ('' == $new && $old) {
				delete_post_meta( $post_id, $name, $old );
			}
		}
		
		# save the total rating
		
		# letter/number equivalents
		$letters=array('A+'=>14,'A'=>13,'A-'=>12,'B+'=>11,'B'=>10,'B-'=>9,'C+'=>8,'C'=>7,'C-'=>6,'D+'=>5,'D'=>4,'D-'=>3,'F+'=>2,'F'=>1);
		$numbers=array(14=>'A+',13=>'A',12=>'A-',11=>'B+',10=>'B',9=>'B-',8=>'C+',7=>'C',6=>'C-',5=>'D+',4=>'D',3=>'D-',2=>'F+',1=>'F');
		
		# get review-specific rating metric
		global $post;
		$rating_metric = it_get_setting('review_rating_metric');
		$metric_meta = get_post_meta($post->ID, IT_META_METRIC, $single = true);
		if(!empty($metric_meta) && $metric_meta!='') $rating_metric = $metric_meta;	
		$criteria = it_get_setting('review_criteria');
		$count=0;	
		$total=0;
		$ratings=0;
		$weights=0;
		$ratingflag=false;
		#if the review flag is never set below, it means this post has no editor ratings and 
		#does not allow user ratings and thus needs to have a meta flag set that it is not a review
		$reviewflag=false;
		if(!empty($criteria)) {	 #loop thru and save criteria fields
			foreach($criteria as $criterion) {
				if(isset($criterion[0])) {	
					if(is_object($criterion[0])) {			
						$name = $criterion[0]->name;
						$weight = $criterion[0]->weight;			
						$safe_name = $criterion[0]->safe_name;  
						$meta_name = $criterion[0]->meta_name; 
						if(!empty($meta_name)) {					
							# set rating value into variable
							$rating=$_POST[IT_SETTINGS][$meta_name];
							# different averaging method for letter grades
							if ($rating_metric=="letter") $rating=$letters[$rating];
							# set default weight if non-existent or invalid
							if(!is_numeric($weight)) $weight=1;	
							
							# don't include blank ratings in total calculation
							if(!empty($rating) && $rating!='user' && $rating!='none') {
								# increase total score	
								$ratings+=$rating*$weight;
								# increase total weight
								$weights+=$weight;	
								# increase count
								$count++;
								$ratingflag = true;
							} elseif($rating=='user') {
								$ratingflag = true;
							}
						}
					}
				}
			} 
			if($weights == 0) $weights = 1;		
			# get averaged total
			$rating=$ratings/$weights;
			# different rounding based on metric
			switch ($rating_metric) {
				case 'stars':
					$rating = round($rating * 2) / 2; # need to get an even .5 rating for stars
					break;
				case 'percentage':
					$rating = round($rating); # round to the closest whole number
					break;
				case 'number':
					$rating = round($rating, 1); # round to the closest decimal point (tenth place)
					break;
				case 'letter':
					$rating = round($rating); # round to the closest whole number										
					break;
			}
			#need to use override value for normalized value if present
			if(array_key_exists(IT_META_TOTAL_SCORE_OVERRIDE,$_POST[IT_SETTINGS])) {
				$rating_override = $_POST[IT_SETTINGS][IT_META_TOTAL_SCORE_OVERRIDE];
			} else {
				$rating_override = false;
			}
			if(empty($rating_override) || $rating_override=='') {
				$rating_normalized = it_normalize_value($rating, $post_id);				
			} else {
				if($rating_metric=='letter') $rating_override=$letters[$rating_override];
				$rating_normalized = it_normalize_value($rating_override, $post_id);
			}
			if($rating_metric=='letter') $rating=$numbers[$rating]; # turn the rating number back into a letter	
		} 
		# set indicator that no editor ratings were selected
		if($count==0) $rating = 'none';
		# update auto score
		update_post_meta( $post_id, IT_META_TOTAL_SCORE, $rating );
		# update normalized score (for use in cross-type sorting)
		update_post_meta( $post_id, IT_META_TOTAL_SCORE_NORMALIZED, $rating_normalized );
		#set disable review meta
		$disable_review = $ratingflag ? 'false' : 'true';
		#if post type is Article force disable review
		if(array_key_exists(IT_META_POST_TYPE,$_POST[IT_SETTINGS])) {
			$post_type = $_POST[IT_SETTINGS][IT_META_POST_TYPE];
		} else {
			$post_type = '';
		}
		$disable_review = $post_type=='article' ? 'true' : $disable_review;	
		update_post_meta( $post_id, IT_META_DISABLE_REVIEW, $disable_review);
				
		#perform any necessary resets
		if(!empty($_POST[IT_SETTINGS]['_reset_likes'])) {
			delete_post_meta( $post_id, IT_META_TOTAL_LIKES);
			delete_post_meta( $post_id, IT_META_LIKE_IP_LIST);
		}
		if(!empty($_POST[IT_SETTINGS]['_reset_views'])) {
			delete_post_meta( $post_id, IT_META_TOTAL_VIEWS);
			delete_post_meta( $post_id, IT_META_VIEW_IP_LIST);
		}
		if(!empty($_POST[IT_SETTINGS]['_reset_user_ratings'])) {
			delete_post_meta( $post_id, IT_META_TOTAL_USER_SCORE);
			delete_post_meta( $post_id, IT_META_TOTAL_USER_SCORE_NORMALIZED);
			#loop through and delete rating criteria specific meta fields
			if(!empty($criteria)) {	
				foreach($criteria as $criterion) {	
					if(isset($criterion[0])) {	
						if(is_object($criterion[0])) {		 
							$meta_name = $criterion[0]->meta_name.'_user'; 
							if(!empty($meta_name)) {	
								delete_post_meta( $post_id, $meta_name);	
								delete_post_meta( $post_id, $meta_name.'_ips');	
								delete_post_meta( $post_id, $meta_name.'_ratings');					
							}
						}
					}
				} 
			}
		}
		if(!empty($_POST[IT_SETTINGS]['_reset_user_reactions'])) {
			delete_post_meta( $post_id, IT_META_TOTAL_REACTIONS);
			#loop through and delete reaction meta fields
			$reactions = it_get_setting('reactions');
			if ( isset($reactions['keys']) && $reactions['keys'] != '#' ) {
				$reactions_keys = explode(',',$reactions['keys']);
				foreach ($reactions_keys as $rkey) {
					if ( $rkey != '#') {
						$meta_name = ( !empty( $reactions[$rkey]['slug'] ) ) ? '_' . $reactions[$rkey]['slug'] : '#';
						if($meta_name!='#') {	
							delete_post_meta( $post_id, $meta_name);	
							delete_post_meta( $post_id, $meta_name.'_ips');				
						}
					}
				} 
			}
		}	
	}
	
}

?>
