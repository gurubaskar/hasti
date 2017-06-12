<?php
/**
 * @file
 * The primary PHP file for this theme.
 */
function hasti_preprocess_region(&$variables) {
  // Add information about the number of sidebars.
 	if(arg(0) == 'search') {
  		if($variables['region'] == "content"){
        	$variables['classes_array'][] = 'col-xs-12 col-sm-9 col-md-9 plp-right';
    	}
	}
} 