<?php
	include_once "win_head.php";

	$users_privileges = $db->fetch_all_data("users_privileges",[],"id ='".$_GET["id"]."'")[0];
	$_title = "Users Privileges Module <u>".$users_privileges["module_name"]."</u>";
	$arr_1 = pipetoarray($users_privileges["add_user_ids"]);
	asort($arr_1);
	$arr_2 = pipetoarray($users_privileges["edit_user_ids"]);
	asort($arr_2);
	$arr_3 = pipetoarray($users_privileges["delete_user_ids"]);
	asort($arr_3);
	$arr_4 = pipetoarray($users_privileges["approve_user_ids"]);
	asort($arr_4);
	$arr_5 = pipetoarray($users_privileges["view_user_ids"]);
	asort($arr_5);
?>
	<h3><b><?=$_title;?></b></h3>
	<br><br>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("ID","User Add","ID","User Edit","ID","User Delete","ID","User Approve","ID","User View"));?>
	<tr style="vertical-align:top">
		<td>
			<?php
				foreach($arr_1 as $x_1 => $x_val_1){
					echo $x_val_1."<br>";
				}
			?>
		</td>
		<td nowrap>
			<?php
				foreach($arr_1 as $x_1 => $x_val_1){
					echo $db->fetch_single_data("users","name",["id" => $x_val_1])."<br>";
				}
			?>
		</td>
		<td>
			<?php
				foreach($arr_2 as $x_2 => $x_val_2){
					echo $x_val_2."<br>";
				}
			?>
		</td>
		<td nowrap>
			<?php
				foreach($arr_2 as $x_2 => $x_val_2){
					echo $db->fetch_single_data("users","name",["id" => $x_val_2])."<br>";
				}
			?>
		</td>
		<td>
			<?php
				foreach($arr_3 as $x_3 => $x_val_3){
					echo $x_val_3."<br>";
				}
			?>
		</td>
		<td nowrap>
			<?php
				foreach($arr_3 as $x_3 => $x_val_3){
					echo $db->fetch_single_data("users","name",["id" => $x_val_3])."<br>";
				}
			?>
		</td>
		<td>
			<?php
				foreach($arr_4 as $x_4 => $x_val_4){
					echo $x_val_4."<br>";
				}
			?>
		</td>
		<td nowrap>
			<?php
				foreach($arr_4 as $x_4 => $x_val_4){
					echo $db->fetch_single_data("users","name",["id" => $x_val_4])."<br>";
				}
			?>
		</td>
		<td>
			<?php
				foreach($arr_5 as $x_5 => $x_val_5){
					echo $x_val_5."<br>";
				}
			?>
		</td>
		<td nowrap>
			<?php
				foreach($arr_5 as $x_5 => $x_val_5){
					echo $db->fetch_single_data("users","name",["id" => $x_val_5])."<br>";
				}
			?>
		</td>
	</tr>
	<?=$t->end();?>
