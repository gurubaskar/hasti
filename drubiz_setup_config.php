<?php

// ----------------------- //
// CONFIGURATION SETTINGS: //
// ----------------------- //

// Ofbiz Webservices.
$ofbiz_webservice_urls = array(
  'DEV'     => 'http://bg4ws0386/', // Development
  'LAPTOP'  => 'http://localhost:8080/', // Laptop
);

// Domain Configuration.
$domain_configs = array(
  'DEV' => array(
    'www.hasti.dev' => array(
      'dev'       => TRUE,
      'catalog'   => 'hasti',
      'theme'     => 'hasti',
      'homepage'  => 4244, // Node ID of the homepage
    ),
  ),
);
$domain_configs['LAPTOP'] = $domain_configs['DEV'];

// --------------------------------------------------------------------------- //
// DO NOT EDIT anything below this line, unless you know what you're doing! ;) //
// --------------------------------------------------------------------------- //

if (php_sapi_name() != 'cli') die('Can be run via CLI only!' . PHP_EOL);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

echo DRUBIZ_IMPORT_LONG_DELIMITER . PHP_EOL;

echo "Setting up URLs..." . PHP_EOL;

$environment = @$argv[1];

if (!empty($ofbiz_webservice_urls[$environment])) {
  variable_set("drubiz_ofbiz_url", $ofbiz_webservice_urls[$environment]);
  echo "  Ofbiz Webservice setup for $environment" . PHP_EOL;
}
else {
  if (!empty($environment)) {
    echo "Ofbiz Webservices - Invalid Environment specified ($environment)" . PHP_EOL;
  }
  else {
    echo "Please specify an Environment for Ofbiz" . PHP_EOL;
  }
  die("Ofbiz Available Environment Values: " . implode(', ', array_keys($ofbiz_webservice_urls)));
}

echo DRUBIZ_IMPORT_DELIMITER . PHP_EOL;

echo "Setting up Domain Configuration..." . PHP_EOL;

if (!empty($domain_configs[$environment])) {
  variable_set("drubiz_domain_config", $domain_configs[$environment]);
  echo "  Domain Configuration setup for $environment" . PHP_EOL;
}
else {
  if (!empty($environment)) {
    echo "Domain Configuration - Invalid Environment specified ($environment)" . PHP_EOL;
  }
  else {
    echo "Please specify an Environment for Domain Configuration" . PHP_EOL;
  }
  die("Domain Configuration Available Environment Values: " . implode(', ', array_keys($domain_configs)));
}

echo DRUBIZ_IMPORT_DELIMITER . PHP_EOL;

// Done!
echo "CONFIGURATION COMPLETE!" . PHP_EOL;
