<?php
define('USERNAME', 'billings@corphr.com');
define('PASSWORD', 'bismillaahi123');
define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
define('COOKIE_FILE', '../../cookie.txt');
define('LOGIN_FORM_URL', 'https://apportal.nokia.com/APPortalExt/');
define('LOGIN_ACTION_URL', 'https://apportal.nokia.com/APPortalExt/');
 
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($curl, CURLOPT_HEADER, false);
$curl_return = curl_exec($curl);
curl_close($curl);
$fp = fopen("apportal_curl.txt", 'w');
fwrite($fp, $curl_return);

$__VIEWSTATE = explode('id="__VIEWSTATE" value="',$curl_return);
$__VIEWSTATE = explode('" />',$__VIEWSTATE[1])[0];

$__VIEWSTATEGENERATOR = explode('id="__VIEWSTATEGENERATOR" value="',$curl_return);
$__VIEWSTATEGENERATOR = explode('" />',$__VIEWSTATEGENERATOR[1])[0];

$__PREVIOUSPAGE = explode('id="__PREVIOUSPAGE" value="',$curl_return);
$__PREVIOUSPAGE = explode('" />',$__PREVIOUSPAGE[1])[0];

$__EVENTVALIDATION = explode('id="__EVENTVALIDATION" value="',$curl_return);
$__EVENTVALIDATION = explode('" />',$__EVENTVALIDATION[1])[0];

$postValues = array(
    'ctl00_ctl00_ctl00_MainContent_rssm_TSSM' => "",
    'ctl00_ctl00_ctl00_MainContent_rsm_TSM' => "",
    '__EVENTTARGET' => "",
    '__EVENTARGUMENT' => "",
    '__VIEWSTATE' => $__VIEWSTATE,
    '__VIEWSTATEGENERATOR' => $__VIEWSTATEGENERATOR,
    '__VIEWSTATEENCRYPTED' => "",
    '__PREVIOUSPAGE' => $__PREVIOUSPAGE,
    '__EVENTVALIDATION' => $__EVENTVALIDATION,
    'ctl00$ctl00$ctl00$MainContent$MainContent$MainContent$LoginControl$UserName' => USERNAME,
    'ctl00$ctl00$ctl00$MainContent$MainContent$MainContent$LoginControl$Password' => PASSWORD,
    'ctl00$ctl00$ctl00$MainContent$MainContent$MainContent$LoginControl$LoginButton' => "Sign in"
);
 
curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt($curl, CURLOPT_HEADER, true);
$curl_return = curl_exec($curl);
curl_close($curl);
$fp = fopen("apportal_curl.txt", 'w');
fwrite($fp, $curl_return);
?>