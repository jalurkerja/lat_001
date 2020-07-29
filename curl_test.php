<?php
function gethttp_value($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function cipuy($url){
	return gethttp_value($url);	
}

echo "sss";
echo cipuy("http://103.253.113.201/chr_dashboards/api/smtp_notes.php?mode=available&domain=corphr.com");
exit();

define('USERNAME', 'superuser');
define('PASSWORD', 'R2h2s12*');
define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
define('COOKIE_FILE', 'cookie.txt');
define('LOGIN_FORM_URL', 'http://103.253.113.201/chr_dashboards/index.php');
define('LOGIN_ACTION_URL', 'http://103.253.113.201/chr_dashboards/index.php');
$postValues = array(
    'username' => USERNAME,
    'password' => PASSWORD,
    'login_action' => "Login"
);
 
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);
 
//Tell cURL that we want to carry out a POST request.
curl_setopt($curl, CURLOPT_POST, true);
 
//Set our post fields / date (from the array above).
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));
 
//We don't want any HTTPS errors.
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
 
//Where our cookie details are saved. This is typically required
//for authentication, as the session ID is usually saved in the cookie file.
curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
 
//Sets the user agent. Some websites will attempt to block bot user agents.
//Hence the reason I gave it a Chrome user agent.
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
 
//Tells cURL to return the output once the request has been executed.
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
//Allows us to set the referer header. In this particular case, we are 
//fooling the server into thinking that we were referred by the login form.
curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
 
//Do we want to follow any redirects?
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
 
//Execute the login request.
curl_setopt($curl, CURLOPT_HEADER, false);
curl_exec($curl);



 
//Check for errors!
if(curl_errno($curl)){
    throw new Exception(curl_error($curl));
}
 
//We should be logged in by now. Let's attempt to access a password protected page
curl_setopt($curl, CURLOPT_URL, 'http://103.253.113.201/chr_dashboards/po_list.php');
 
//Use the same cookie file.
curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
 
//Use the same user agent, just in case it is used by the server for session validation.
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
 
//We don't want any HTTPS / SSL errors.
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
 
//Execute the GET request and print out the result.

$curl_return = curl_exec($curl);
curl_close($curl);
$fp = fopen("curl.txt", 'w');
fwrite($fp, $curl_return);
fclose($fp);

// var_dump($curl_return);
?>