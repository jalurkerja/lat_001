<?php
//==
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
        if (preg_match('/NT 6.2/i', $u_agent)) { $platform .= ' 8'; }
            elseif (preg_match('/NT 6.3/i', $u_agent)) { $platform .= ' 8.1'; }
            elseif (preg_match('/NT 6.1/i', $u_agent)) { $platform .= ' 7'; }
            elseif (preg_match('/NT 6.0/i', $u_agent)) { $platform .= ' Vista'; }
            elseif (preg_match('/NT 5.1/i', $u_agent)) { $platform .= ' XP'; }
            elseif (preg_match('/NT 5.0/i', $u_agent)) { $platform .= ' 2000'; }
        if (preg_match('/WOW64/i', $u_agent) || preg_match('/x64/i', $u_agent)) { $platform .= ' (x64)'; }
    }
   
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }
   
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
	
//==

function login_action($username,$password,$forget){
	global $_SERVER,$_SESSION,$db,$_POST,$v;
	$time_start 	= date("Y-m-d H:i:s", mktime((date("H")-3),date("i"),date("s"),date("m"),date("d"),date("Y")));
	$cek_failed		= $db->fetch_all_data("login_failed",[],"(username = '".is_text($username)."') AND created_at >= '".$time_start."'");
	if(count($cek_failed) < 3){
		$str 		= file_get_contents('https://ipinfo.io/'.$_SERVER["REMOTE_ADDR"].'/json');
		$json 		= json_decode($str, true);
		$browser	= getBrowser();
		
		$db->addtable("users");
		$db->addfield("id");
		$db->addfield("name");
		$db->addfield("password");
		$db->addfield("hidden");
		$db->addfield("sign_in_count");
		$db->addfield("current_sign_in_at");
		$db->addfield("last_sign_in_at");
		$db->addfield("current_sign_in_ip");
		$db->addfield("last_sign_in_ip");
		$db->where("email",is_text($username));
		$db->limit(1);
		$users = $db->fetch_data();
		if(count($users) > 0){
			if($forget && $users["password"] != base64_encode(is_text($password)) && $users["hidden"] == "0"){
				$new_pass = "";
				for($i=1; $i<=6; $i++){
					$new_pass .=rand(0,9);
				}
				$db->addtable("users");			$db->where("email",is_text($username));
				$db->addfield("password");		$db->addvalue(base64_encode($new_pass));
				$updating = $db->update();
				if($updating["affected_rows"] >= 0){
					include_once "func.sendingmail.php";
					$message = "Dear <b><i>".ucwords($users["name"])."</i></b>, <br><br><br>
								Berikut ini adalah password terbaru Anda:<br><br>
								<b>".$new_pass."</b><br><br>
								Silahkan Login menggunakan Alamat Email Anda dan Password tersebut.
								<br><br>
								<a target='blank' href=\"https://dashboard.corphr.com/indottech/index.php\">Login Ke Indottech dashboards</a> <br>
								<a target='blank' href=\"https://play.google.com/store/apps/details?id=appinventor.ai_dhovekss.indottech&hl=in\">Download Indottech Apps</a> <br><br>
								<br>
								<p style='font-family: Courier 10 Pitch; font-weight:bolder'>
								Tim IT<br>
								PT. Indo Human Resource<br>
								Epicentrum Walk Office 7th Floor, Suite 0709A<br>
								Kompleks Rasuna Epicentrum  Jl. HR. Rasuna Said - Kuningan<br>
								Jakarta Selatan 12940<br>
								Phone       : 021-2994 1058/59
								</p>
								<img src='https://dashboard.corphr.com/indottech/images/logo indottech.jpg' width=20% height=20%>";
					sendingmail("Indottech Notification",is_text($username),$message);
					$_SESSION["errormessage"] = "Silahkan Cek Email Masuk Anda untuk mengetahui Password Terbaru";
				}
			} else {
				if($users["password"] == base64_encode(is_text($password)) && $users["hidden"] == "0"){
					$_SESSION["errormessage"] = "";
					$_SESSION["username"] = is_text($username);
					$_SESSION["fullname"] = $db->fetch_single_data("users","name",array("id" => $users["id"]));
					$_SESSION["group_id"] = $db->fetch_single_data("users","group_id",array("id" => $users["id"]));
					$_SESSION["isloggedin"] = 1;
					$_SESSION["user_id"] = $users["id"];
					
					$db->addtable("users"); 
					$db->where("id",$users["id"]);
					$db->addfield("sign_in_count");$db->addvalue($users["sign_in_count"] + 1);
					$db->addfield("current_sign_in_at");$db->addvalue(date("Y-m-d H:i:s"));
					$db->addfield("last_sign_in_at");$db->addvalue($users["current_sign_in_at"]);
					$db->addfield("current_sign_in_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
					$db->addfield("last_sign_in_ip");$db->addvalue($users["current_sign_in_ip"]);
					$db->update(); 
					
					$db->addtable("log_histories"); 
					$db->addfield("user_id");$db->addvalue($users["id"]);
					$db->addfield("email");$db->addvalue(is_text($username));
					$db->addfield("x_mode");$db->addvalue(1);
					$db->addfield("log_at");$db->addvalue(date("Y-m-d H:i:s"));
					$db->addfield("log_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
					$db->addfield("city");		$db->addvalue($json["city"]);
					$db->addfield("region");	$db->addvalue($json["region"]);
					$db->addfield("country");	$db->addvalue($json["country"]);
					$db->addfield("loc");		$db->addvalue($json["loc"]);
					$db->addfield("org");		$db->addvalue($json["org"]);
					$db->addfield("timezone");	$db->addvalue($json["timezone"]);
					$db->addfield("browser");	$db->addvalue($browser["name"]);
					$db->insert();

					return 1;
				} else {
					$db->addtable("login_failed");
					$db->addfield("username");			$db->addvalue(is_text($username));
					$db->addfield("password");			$db->addvalue(is_text($password));
					$db->addfield("device_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
					$db->addfield("city");				$db->addvalue($json["city"]);
					$db->addfield("region");			$db->addvalue($json["region"]);
					$db->addfield("country");			$db->addvalue($json["country"]);
					$db->addfield("loc");				$db->addvalue($json["loc"]);
					$db->addfield("org");				$db->addvalue($json["org"]);
					$db->addfield("timezone");			$db->addvalue($json["timezone"]);
					$db->addfield("browser");			$db->addvalue($browser["name"]);
					$inserting = $db->insert();
					
					$_SESSION["errormessage"] = "Kesalahan pada Username atau Password";
					if(count($cek_failed) >= 1){
						include_once "func.sendingmail.php";
						$pesannya	= "<b>".is_text($username)."</b> mencoba login dengan password ".is_text($password)."<br>Tindakan ke : ".(count($cek_failed)+1)." Di ".$json["city"]." - ".$json["region"]." - ".$json["country"];
						sendingmail("Indottech Login Failed ".is_text($username),"it@corphr.com",$pesannya);
					}
					return 0;
				}
			}
		} else {
			$db->addtable("login_failed");
			$db->addfield("username");				$db->addvalue(is_text($username));
			$db->addfield("password");				$db->addvalue(is_text($password));
			$db->addfield("device_ip");				$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->addfield("city");					$db->addvalue($json["city"]);
			$db->addfield("region");				$db->addvalue($json["region"]);
			$db->addfield("country");				$db->addvalue($json["country"]);
			$db->addfield("loc");					$db->addvalue($json["loc"]);
			$db->addfield("org");					$db->addvalue($json["org"]);
			$db->addfield("timezone");				$db->addvalue($json["timezone"]);
			$db->addfield("browser");				$db->addvalue($browser["name"]);
			$inserting = $db->insert();
			
			$_SESSION["errormessage"] = "Kesalahan pada Username atau Password";
			return 0;
		}
	} else {
		$_SESSION["errormessage"] = "Maaf Anda sudah tiga kali melakukan kesalahan login, silahkan hubungi Team IT untuk proses lebih lanjut.";
		return 0;
	}
	return 0;
}


if(is_text(isset($_GET["logout_action"]))){
	
	$db->addtable("log_histories"); 
	$db->addfield("user_id");$db->addvalue($__user_id);
	$db->addfield("email");$db->addvalue($__username);
	$db->addfield("x_mode");$db->addvalue(2);
	$db->addfield("log_at");$db->addvalue(date("Y-m-d H:i:s"));
	$db->addfield("log_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
	$db->insert(); 
	
	$_SESSION=array();
	session_destroy();
	
	?> <script language="javascript"> window.location='index.php'; </script><?php
}

if(is_text(isset($_POST["login_action"]))){
	$_POST["username"]	= is_text($_POST["username"]);
	$_POST["password"]	= is_text($_POST["password"]);
	$captcha			= $_POST['g-recaptcha-response'];
	//di bawah ini silahkan masukkan pada gambar di atas pada kotak hijau
	$__data_secretKey	= $_POST["data_secretKey"];
	$ip 				= $_SERVER['REMOTE_ADDR'];
	$response			= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$__data_secretKey."&response=".$captcha."&remoteip=".$ip);
	$responseKeys		= json_decode($response,true);
	
	if($ip == "localhost" || $ip == "127.0.0.1"){
		login_action($_POST["username"],$_POST["password"],$_POST["forget"]);
		if($_SESSION["isloggedin"]){
			?> <script language="javascript"> window.location='<?=basename($_SERVER["PHP_SELF"]);?>'; </script> <?php
		}
	} else {
		if(intval($responseKeys["success"]) !== 1) {
			//pesan jika reCAPTCHA tidak di centang
			$_SESSION["errormessage"] = "Login failed";
		}else{
			//pesan jika reCAPTCHA berhasil
			login_action($_POST["username"],$_POST["password"],$_POST["forget"]);
			if($_SESSION["isloggedin"]){
				?> <script language="javascript"> window.location='<?=basename($_SERVER["PHP_SELF"]);?>'; </script> <?php
			}
		}
	}
}
?>