<?php

if (php_sapi_name() != 'cli') die('Can be run via CLI only!' . PHP_EOL);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$products_count = db_query("SELECT COUNT(nid) FROM {node} WHERE type = 'product'")->fetchField();
if ($products_count > 0) {
  $products = db_query("SELECT nid FROM {node} WHERE type = 'product'");
  $count = 0;
  foreach ($products as $product) {
    $count++;
    $pct = round($count * 100 / $products_count, 2);
    echo "Deleting Product NID {$product->nid}...";
    node_delete($product->nid);
    echo " DONE! $count / $products_count ({$pct}%)" . PHP_EOL;
  }
}
else {
  echo "No Products to delete!" . PHP_EOL;
}
