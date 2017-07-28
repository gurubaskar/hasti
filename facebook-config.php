<?php
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\GraphUser;

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// init app with app id and secret
//FacebookSession::setDefaultApplication( '468993356803640','d6e6532df7467c0eff38583818a4e7e8' );
FacebookSession::setDefaultApplication( '270991780046160','ace3b2e5daa6b4e91b8286d5df890c51' );

// login helper with redirect_uri
 //$helper = new FacebookRedirectLoginHelper('http://www.hasti.dev/drubiz_hasti/facebook-config.php' );
$helper = new FacebookRedirectLoginHelper('http://www.hastti.com/facebook-config.php');

try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
 $request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=id,name,first_name,last_name,gender,email' );//induspro9@gmail.com
  $response = $request->execute();
  // get response  GraphLocation::className()
  $graphObject = $response->getGraphObject(GraphUser::className());
  $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
	  $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
    $fbemail = $graphObject->getProperty('email');    // To Get Facebook email ID

    // added only for offbiz service facebook login
    $gender = $graphObject->getProperty('gender');    // To Get Facebook Gender
    $fbfirstname = $graphObject->getProperty('first_name');//To Get Facebook first name
    $fblastname = $graphObject->getProperty('last_name');//To Get Facebook last name
    //end
    /* ---- Session Variables -----*/
    $_SESSION['FBID'] = $fbid;           

    //call cack for offbiz service
    $responseData = fb_google_api_login_request($fbfirstname,$fblastname,$fbemail,$gender);
    /* ---- header location after session ----*/
 //header("Location: http://www.hasti.dev/drubiz_hasti/index.php");
   header("Location: http://www.hastti.com/index.php");
} else {
  $loginUrl = $helper->getLoginUrl(array(
   'scope' => 'email'
  ));
 header("Location: ".$loginUrl);
}
?>