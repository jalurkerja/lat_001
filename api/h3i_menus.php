<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="../backoffice.css">
	</head>
	<body>
		<style>
			a{
				text-decoration:none;
				color:#43579C;
			}
			button{
				width:90px;
				height:90px;
				font-weight:bolder;
				font-size:14px;
			}
		</style>
<?php 
	include_once "../common.php";
	include_once "user_info.php";
	$trial = 1;		$release = 0;
	$version = $db->fetch_single_data("indottech_version","version",["id" => "1"]);
	if(
		($trial == 1 && ($__user_id == "1" || $__user_id == "165" || $__user_id == "185" || $__user_id == "186" || $__user_id == "187" || $__user_id == "461" || $__user_id == "462" || $__user_id == "497" || $__user_id == "184"))
		||
		($trial == 0)
	) $release = 1;
	
	$message = "";
	$menus[]["h3i_photo_attachments"] = "ATP Dismantle PAR";
	if($release > 0 || $version == 43) $menus[]["tssr_new_sites"] = "TSSR New Site";
?>
		<table width="100%">
			<tr><td align="center">
				<table width="100%">
					<tr>
						<?php 
							$ii = -1;
							foreach($menus as $menu) {
								$ii++;
								?> <td width="31%" align="center"><button onclick="window.location='<?=key($menu);?>.php?token=<?=$_GET["token"];?>';"><?=$menu[key($menu)];?></button></td> <?php
								if($ii < 2){
									?> <td width="3%">&nbsp;</td> <?php
								} else {
									?> </tr><tr><td></td></tr><tr> <?php
									$ii = -1;
								}
							}
						?>
					</tr>
				</table>
			</td></tr>
		</table>
	</body>
</html>
