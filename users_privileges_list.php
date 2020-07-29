<?php include_once "head.php";?>
<?php
	$_SESSION["users_privileges_group"] = "";
	$_SESSION["users_privileges_add"] = "";
	$_SESSION["users_privileges_edit"] = "";
	$_SESSION["users_privileges_delete"] = "";
	$_SESSION["users_privileges_approve"] = "";
	$_SESSION["users_privileges_view"] = "";
?>
<?php
	if(@$_GET["deleting"]){
		$db->addtable("users_privileges");$db->where("id",$_GET["deleting"]);$db->delete_();
		?> <script> window.location="?";</script> <?php
	}
?>
<div class="bo_title">List User Privileges</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$module_name = $f->input("search",@$_GET["search"],"classinput");
			?>
			<?=$t->row(array("Search",$module_name));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'","btn btn-primary");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"","btn btn-warning");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	$db->addtable("users_privileges");
	if(@$_GET["search"]!="") $whereclause .= "module_name LIKE '%".$_GET["search"]."%' OR in_menus LIKE '%".$_GET["search"]."%' AND ";
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("users_privileges");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	$db->order("created_at DESC");
	$users_privileges = $db->fetch_data(true);
?>
<?php
	if(@$_SESSION["group_id"] == 0){
		echo $f->input("add","Add","type='button' onclick=\"window.location='".str_replace("_list","_add",$_SERVER["PHP_SELF"])."';\"","btn btn-primary");
	}
?>	
	<?=$paging;?>
	<table id="data_content">
		<tr>
			<th width="3%">No</th>
			<th width="17%">Module Name</th>
			<th>Menu Terkait</th>
			<th width="7%">Action</th>
		</tr>
		<?php
			foreach($users_privileges as $no => $module_name){
				$edit = "<a href=\"".str_replace("_list","_edit",$_SERVER["PHP_SELF"])."?id=".$module_name["id"]."\">Edit</a>";
				// if($_SESSION["group_id"] == 0){
					// $edit .= " | <a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$module_name["id"]."';}\">Delete</a>";
				// }
				$onclick = "onclick = '$.fancybox.open({ href: \"sub_window/win_users_privileges_module.php?id=".$module_name["id"]."\", height: \"80%\", type: \"iframe\" });'";
				?>
				<tr <?=$onclick;?> >
					<td><?=$no+$start+1;?></td>
					<td><?=$module_name["module_name"];?></td>
					<td><?=$module_name["in_menus"];?></td>
					<td><?=$edit;?></td>
				</tr>
				<?php
			}
		?>
	</table>
	
	<?=$paging;?>
<?php include_once "footer.php";?>