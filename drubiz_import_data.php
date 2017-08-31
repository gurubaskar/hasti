<?php
 
// ----------------------- //
// CONFIGURATION SETTINGS: //
// ----------------------- //
 
// XLS Catalog Configuration Format:
// array(
//   '<catalog_machine_name>' => 'path/to/catalog.xls',
// )
$xls_files = array(
   'hasti'    => 'drubiz_data/catalog_hasti.xls',
);
 
// --------------------------------------------------------------------------- //
// DO NOT EDIT anything below this line, unless you know what you're doing! ;) //
// --------------------------------------------------------------------------- //
 
if (php_sapi_name() != 'cli') die('Can be run via CLI only!' . PHP_EOL);
 
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
 
define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
 
drubiz_import_data($xls_files);