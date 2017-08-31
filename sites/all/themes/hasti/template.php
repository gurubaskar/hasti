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
function hasti_breadcrumb($variables) {
  global $drubiz_domain;
  if (!empty($variables['breadcrumb'])) {
    $category_names_hasti = json_decode(json_decode(json_encode(variable_get('drubiz_category_names'))),true);
    $category_names = $category_names_hasti[$drubiz_domain['catalog']];
    foreach ($variables['breadcrumb'] as $breadcrumb_key => $breadcrumb) {
      if (!is_array($breadcrumb)) {
        $link = preg_match("/\>(.*)<\/a>/i", $breadcrumb, $matches);
        if (!empty($matches[1]) AND preg_match("/^[0-9]+$/", $matches[1])) {
          if (!empty($category_names[(string)$matches[1]])) {
            $variables['breadcrumb'][$breadcrumb_key] = str_replace('>' . $matches[1] . '</a>', '>' . $category_names[(string)$matches[1]] . '</a>', $breadcrumb);
            continue;
          }
        }
        $standalone = preg_match("/^[0-9]+$/i", $breadcrumb);
        if ($standalone AND !empty($category_names[(string)$breadcrumb])) {
          $variables['breadcrumb'][$breadcrumb_key] = $category_names[(string)$breadcrumb];
        }
        //drupal_set_message("ctype=".ctype_digit($breadcrumb)."<pre>".print_r($breadcrumb, 1)."</pre>"." and ".$category_names[(string)$breadcrumb]);
        if(isset($category_names[(string)$breadcrumb])) {}
        else {
          unset($variables['breadcrumb'][$breadcrumb_key]);
        }
      }
    }
  }
  //$breadcrumb_final = array_slice($variables['breadcrumb'], 0, -1);
  $breadcrumb_final = $variables['breadcrumb'];
  global $base_path;
  $home_breadcrumb = '<a href="'.$base_path.'">Home</a>';
  if(count($breadcrumb_final) > 0) {
    array_unshift($breadcrumb_final, $home_breadcrumb);
  }
  //dsm($breadcrumb_final);
  $output = theme('item_list', array(
    'attributes' => array(
      'class' => array('breadcrumb'),
    ),
    'items' => $breadcrumb_final,
    'type' => 'ol',
  ));
  return $output;
}
