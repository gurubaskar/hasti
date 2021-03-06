<?php
require_once ('libraries/Google/autoload.php');

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
/*$client_id='1001369029674-4lco05hqh7mo03r2ff276u61324v5m74.apps.googleusercontent.com'; 
$client_secret = '2aNHpIHrIeMdGyUJyZGz1igB';
$redirect_uri = 'http://www.hasti.dev/drubiz_hasti/google-config.php';*/

$client_id='1272075537-jljqh6kmh1shr5g483ca6g8fighgvt74.apps.googleusercontent.com'; 
$client_secret = '5JXORhCBJukgvzlrr5_xUyCk';
$redirect_uri = 'https://www.hastti.com/google-config.php';

//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}
//$_SESSION['redirecturl'] = $_GET['redirurl'];

//Display user info or display login url as per the info we have.
if (isset($authUrl)){ 
	//show login url
	header('Location:'.$authUrl);	
} else {	
	$user = $service->userinfo->get(); //get user info 
	//$user->id,  $user->name, $user->email, $user->link, $user->picture
	$gfirstname=$user->givenName;
	$glastname=$user->familyName;
	$gemail=$user->email;
	$gender=$user->gender;	
  $pageurl = $_SESSION['redirurl'];
	$responseData = fb_google_api_login_request($gfirstname,$glastname,$gemail,$gender,$pageurl);
	$reurl = $_SESSION['drubiz']['session']['redirecturl'];
  if(isset($reurl)){
    $url = $reurl; // holds url for last page visited.
    header('Location:'.$url);
  } else{
    $url = "index.php"; // default page for 
    header('Location:https://www.hastti.com/index.php');
  }    
	//header('Location:http://www.hasti.dev/drubiz_hasti/index.php');
	
}
?>

