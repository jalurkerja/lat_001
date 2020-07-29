<?php
	$_isexport = false;
	if(@$_GET["export"]){
		$_exportname = "Team_list_".date("Ymd_Hi").".xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=".$_exportname);
		header("Pragma: no-cache");
		header("Expires: 0");
		$_GET["do_filter"]="Load";
		$_isexport = true;
	}
 include_once "head.php";
 if(!$_isexport){
	if($_GET["izinkan"]){
		$db->addtable("login_failed");
		$db->awhere("username = '".$_GET["izinkan"]."' OR device_ip = '".$_GET["izinkan"]."' AND ");
		$tes = $db->delete_();
		javascript("window.location='?';");
	}
 ?>
<div class="bo_title">Users</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$group = $f->select("group",$db->fetch_select_data("groups","id","name",["id" => $__group_app.":IN"],array(),"",true),@$_GET["group"],"style='height:25px; width:100%'");
				$os_code = $f->input("os_code",@$_GET["os_code"]);
				$txt_email = $f->input("txt_email",@$_GET["txt_email"]);
				$txt_name = $f->input("txt_name",@$_GET["txt_name"]);
				$txt_job_title = $f->input("txt_job_title",@$_GET["txt_job_title"]);
				$txt_job_division = $f->input("txt_job_division",@$_GET["txt_job_division"]);
				$under_pm = $f->select("under_pm",$db->fetch_select_data("users","id","name",["group_id" => "13,15,16,17,18,23:IN" , "id" => "185:!=", "hidden" => "0"],array("name"),"",true),@$_GET["under_pm"],"style='height:25px; width:100%'");
				$region = $f->select("region_id",$db->fetch_select_data("indottech_regions","id","name",["hidden" => "0"],array("name"),"",true),@$_GET["region_id"],"style='height:25px; width:100%'");
			?>
			<?=$t->row(array("Group",$group));?>
			<?=$t->row(array("OS Code",$os_code));?>
			<?=$t->row(array("Email",$txt_email));?>
			<?=$t->row(array("Name",$txt_name));?>
			<?=$t->row(array("Job Title",$txt_job_title));?>
			<?=$t->row(array("Job Division",$txt_job_division));?>
			<?=$t->row(array("Under ZM / PM / PD",$under_pm));?>
			<?=$t->row(array("Region",$region));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit' style='width:150px;'", "btn btn-primary");?>
			<?=$f->input("reset","Reset","type='button' style='width:150px;' onclick=\"window.location='?';\"", "btn btn-warning");?>
			<?=$f->input("export","Export to Excel","type='submit' style='width:150px;'","btn btn-success");?>
		<?=$f->end();?>
	</div>
</div>

<?php
 }
	$whereclause = "";
	$forbidden_chr_dashboards = $db->fetch_single_data("users","forbidden_chr_dashboards",["id"=>$__user_id]);
	$whereclause = "forbidden_chr_dashboards = '6' AND ";
	if(@$_SESSION["group_id"] > 0)	$whereclause .= "hidden = '0' AND ";
	if(@$_GET["group"]!="") $whereclause .= "group_id = '".$_GET["group"]."' AND ";
	if(@$_GET["os_code"]!="") $whereclause .= "candidate_code LIKE '"."%".str_replace(" ","%",$_GET["os_code"])."%"."' AND ";
	if(@$_GET["txt_email"]!="") $whereclause .= "email LIKE '"."%".str_replace(" ","%",$_GET["txt_email"])."%"."' AND ";
	if(@$_GET["txt_name"]!="") $whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["txt_name"])."%"."' AND ";
	if(@$_GET["txt_job_title"]!="") $whereclause .= "job_title LIKE '"."%".str_replace(" ","%",$_GET["txt_job_title"])."%"."' AND ";
	if(@$_GET["under_pm"]!="") $whereclause .= "(pm_user_id = '".$_GET["under_pm"]."' OR id = '".$_GET["under_pm"]."') AND ";
	if(@$_GET["region_id"]!="") $whereclause .= "(region_id = '".$_GET["region_id"]."') AND ";
	
	$db->addtable("users");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("users");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
	if(!$_isexport){
			$db->limit($start.",".$_rowperpage);
		}
	// $db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$users = $db->fetch_data(true);
 if(!$_isexport){
?>
	<?=$f->input("add","Add","type='button' onclick=\"window.location='users_add.php';\"", "btn btn-primary");?>
	<?=$paging;?>
 <?php } ?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('email');\">Email</div>",
						"<div onclick=\"sorting('name');\">Name</div>",
						"<div onclick=\"sorting('');\">Login Failed</div>",
						"<div onclick=\"sorting('candidate_id');\">Candidate ID</div>",
						"<div onclick=\"sorting('group_id');\">Group Names</div>",
						"<div onclick=\"sorting('job_title');\">Job Title</div>",
						"<div onclick=\"sorting('job_division');\">Job Division</div>",
						"<div onclick=\"sorting('pm_user_id');\">Under ZM / PM / PD</div>",
						"<div onclick=\"sorting('hidden');\">Status</div>",
						"<div onclick=\"sorting('region_id');\">Region</div>",
						"<div onclick=\"sorting('on_board');\">On Board</div>",
						"<div onclick=\"sorting('created_at');\">Created At</div>",
						
						""));?>
	<?php foreach($users as $no => $user){ ?>
		<?php
			$login_failed	= "";
			$login_failed	= count($db->fetch_all_data("login_failed",[],"username LIKE '".$user["email"]."' AND created_at LIKE '%".date("Y-m-d")."%'"));
			$onclick_1		= "";
			if($login_failed >= 3 && ($__user_id == "1" || $__group_id == "1")){
				$onclick_1		= "onclick=\"window.location='?izinkan=".$user["email"]."';\"";
			}
			
			$actions 	= 	"<a href=\"users_edit.php?id=".$user["id"]."\">Edit</a>";
			if($__username == "superuser"){
				$user["email"] .= " [".base64_decode($db->fetch_single_data("users","password",array("id" => $user["id"])))."]";
			}
			$group 			= $db->fetch_single_data("groups","name",array("id"=>$user["group_id"]));
			$hidden 		= ["0" => "Active", "1" => "Not Active"];
			
		?>
		<?=$t->row(
					array($no+$start+1,
					"<a href=\"users_edit.php?id=".$user["id"]."\">".$user["email"]."</a>",
					$user["name"],
					$login_failed,
					$user["candidate_code"],
					$group,
					$user["job_title"],
					$user["job_division"],
					$db->fetch_single_data("users","name",["id" => $user["pm_user_id"]]),
					$hidden[$user["hidden"]],
					$db->fetch_single_data("indottech_regions","name",["id" => $user["region_id"]]),
					$user["on_board"],
					$user["created_at"],
					$actions),
					array("align='right' valign='top' nowrap ",
						"nowrap ",
						"nowrap ",
						"nowrap ".$onclick_1,
						"nowrap ")
				);?>
	<?php } ?>
	<?=$t->end();?>
 <?php if(!$_isexport){
	echo $paging;
 } ?>
	
<?php include_once "footer.php";?>