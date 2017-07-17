<?php

// ----------------------- //
// CONFIGURATION SETTINGS: //
// ----------------------- //

// XLS Catalog Configuration Format:
// array(
//   '<catalog_machine_name>' => 'path/to/catalog.xls',
// )



// --------------------------------------------------------------------------- //
// DO NOT EDIT anything below this line, unless you know what you're doing! ;) //
// --------------------------------------------------------------------------- //
if (php_sapi_name() != 'cli') die('Can be run via CLI only!' . PHP_EOL);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// get the filename from the variable 
//$arg = arg();
//if(isset($arg[0])) {
//	$file_name = 'drubiz_data/catalog_hasti.xls';
//}else {
  $status = variable_get('cron_status');

  if($status == "started" || $status =="running" ) {
  	echo 'IF ==';
  }else {
  	echo 'ELSE ==';
  	  $file_path = variable_get('import_data_status');      
      $file = json_decode(json_decode($file_path,true),true);
      $file_name = $file['filename'];
  	  $xls_files = array(
 		'hasti'	  => array($file_name),
	  );
    drubiz_import_data($xls_files['hasti']);
}