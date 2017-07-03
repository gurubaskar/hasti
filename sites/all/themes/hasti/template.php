<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

/*

function hasti_preprocess_region(&$variables) {
  // Add information about the number of sidebars.
 	if(arg(0) == 'search') {
  		if($variables['region'] == "content"){
        	$variables['classes_array'][] = 'col-xs-12 col-sm-9 col-md-9 plp-right';
    	}
	}
}
*/
function hasti_preprocess_node(&$variables) {
  // Add information about the number of sidebars.
 	if(arg(0) == 'search') {
  		if($variables['region'] == "content"){
        	$variables['classes_array'][] = 'col-xs-12 col-sm-9 col-md-9 plp-right';
    	}
	}
  // Get a list of all the regions for this theme
  foreach (system_region_list($GLOBALS['theme']) as $region_key => $region_name) {

    // Get the content for each region and add it to the $region variable
    if ($blocks = block_get_blocks_by_region($region_key)) {
      $variables['region'][$region_key] = $blocks;
    }
    else {
      $variables['region'][$region_key] = array();
    }
  }
}