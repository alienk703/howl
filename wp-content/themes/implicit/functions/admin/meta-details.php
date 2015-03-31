<?php
$meta_boxes = array(
	'title' => sprintf( __( 'Details', IT_TEXTDOMAIN ), THEME_NAME ),
	'id' => 'it_post_details',
	'pages' => array( 'post' ),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array()
);

#populate the details fields array
$details_fields = array();	
$details = it_get_setting('review_details');
$details = !empty($details) ? $details : array();				
foreach($details as $detail) {	
	if(isset($detail[0]) && is_object($detail[0])) {
		$name = $detail[0]->name;  
		$meta_name = $detail[0]->meta_name; 
		if(!empty($name)) {
			array_push($details_fields, 
				array(
					'name' => $name,
					'id' => $meta_name,					
					'type' => 'textarea'
				)
			);
		}
	}
}

#add criteria fields array to meta boxes array
$meta_boxes['fields'] = array_merge($meta_boxes['fields'],$details_fields);

return array(
	'load' => true,
	'options' => $meta_boxes
);

?>
