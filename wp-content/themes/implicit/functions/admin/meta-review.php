<?php
$default_type = it_get_setting('post_type_default'); #users can change the default post type in theme options
$meta_boxes = array(
	'title' => sprintf( __( 'Review Options', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_post_review',
	'pages' => array( 'post' ),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(		
		array(
			'name' => __( 'Post Type', IT_TEXTDOMAIN ),
			'id' => IT_META_POST_TYPE,
			'desc' =>  __( 'Set this to review if you want it to display as a review type post.', IT_TEXTDOMAIN ),
			'options' => array( 
				'article' => __( 'Article', IT_TEXTDOMAIN ),
				'review' => __( 'Review', IT_TEXTDOMAIN ),
			),
			'default' => $default_type,
			'type' => 'radio'
		),
		array(
			'name' => __( 'Positives', IT_TEXTDOMAIN ),
			'id' => IT_META_POSITIVES,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Negatives', IT_TEXTDOMAIN ),
			'id' => IT_META_NEGATIVES,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Bottom Line', IT_TEXTDOMAIN ),
			'id' => IT_META_BOTTOM_LINE,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Rating Metric', IT_TEXTDOMAIN ),
			'desc' => __( 'Leave this unselected unless you want to override the default rating metric set in the theme options.', IT_TEXTDOMAIN ),
			'id' => IT_META_METRIC,
			'options' => array( 
				'stars' => __( 'Stars', IT_TEXTDOMAIN ),
				'number' => __( 'Numbers', IT_TEXTDOMAIN ),
				'percentage' => __( 'Percentages', IT_TEXTDOMAIN ),
				'letter' => __( 'Letter Grades', IT_TEXTDOMAIN )
			),
			'type' => 'radio'
		),	
	)
);

#populate the rating criteria fields array
$criteria_fields = array();	
$rating_metric = it_get_setting('review_rating_metric');
$postid = '';
if(isset($_GET['post'])) $postid = $_GET['post'];
$metric_meta = get_post_meta($postid, IT_META_METRIC, $single = true);
if(!empty($metric_meta) && $metric_meta!='') $rating_metric = $metric_meta;
$criteria = it_get_setting('review_criteria');	
$criteria = !empty($criteria) ? $criteria : array();		
foreach($criteria as $criterion) {	
	if(isset($criterion[0]) && is_object($criterion[0])) {
		$name = $criterion[0]->name;  
		$meta_name = $criterion[0]->meta_name; 
		if(!empty($name)) {
			array_push($criteria_fields, 
				array(
					'name' => $name,
					'desc' =>  __( 'Leave blank or set to No Rating to exclude this criteria from the ratings for this post.', IT_TEXTDOMAIN ),
					'id' => $meta_name,
					'target' => 'rating_' . $rating_metric,
					'nodisable' => false,
					'type' => 'select'
				)
			);
		}
	}
}

#add total override if there is at least one criteria setup
if(!empty($criteria_fields)) {
	array_push($criteria_fields,
		array(
			'name' => __( 'Total Score Override', IT_TEXTDOMAIN),
			'desc' =>  __( 'Use this setting to manually override the auto-calculated total rating based on the criteria above. Leave it unset to use the auto-calculated value.', IT_TEXTDOMAIN ),
			'id' => IT_META_TOTAL_SCORE_OVERRIDE,
			'target' => 'rating_' . $rating_metric,
			'nodisable' => true,
			'type' => 'select'
		)
	);
}

#add criteria fields array to meta boxes array
$meta_boxes['fields'] = array_merge($meta_boxes['fields'],$criteria_fields);

return array(
	'load' => true,
	'options' => $meta_boxes
);

?>
