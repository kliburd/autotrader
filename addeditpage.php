<?php if($memtype==9){ 
	$action=$_GET['action'];
	$id=mysqli_real_escape_string($coni,$_GET['id']);
	$the_title="Pages";
	if($action=="newpage" || $action=="addpage")	$the_title="Add new page";
	if($action=="editpage")	$the_title="Edit page";
	if($action=="updatepage")	$the_title="Update page";
	if($action=="deletepage") $the_title="Delete page";
	?>
<div id='perimeter'>
<fieldset id='reProfilePage'>
<legend>
<b><?php print $the_title;?></b>
</legend>
<?php 
if($action=="") $action=$_POST['action'];

if($action!="newpage"){
	include("config.php");
	$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
	mysqli_select_db($coni,$database);
	mysqli_query($coni,"SET NAMES utf8");	
}else addPageForm(); 

if($action=="")	showPageList();
if($action=="addpage")	addNewPage();
if($action=="editpage")	editPageForm($id);
if($action=="updatepage")	updatePage();
if($action=="deletepage") deletePage($id);
?>
</fieldset>
</div>

<?php }

function showPageList(){
include("config.php");
$qr="select * from $pageTable;";	
$result0=mysqli_query($coni,$qr);
$totpages=mysqli_num_rows($result0);
if($totpages>0){
?>
<table width='850' class='table table-striped'>
<thead><tr><th align='center'><b>#</b></th><th><b>Page Name</b></th><th><b>Page Order</b></th><th><b>Date/Time added</b></th><th><b>Action</b></th></tr></thead>
<tbody>
<?php
$i=0;
while($row=mysqli_fetch_assoc($result0)){
	$i++;
	print "<tr><td align='center'>$i</td>
	<td>".$row['page_name']."</td>
	<td>".$row['page_order']."</td>
	<td>".$row['dttm']."</td>
	<td><span class='action_icon'><a href='index.php?ptype=addeditpage&id=".$row['id']."&action=editpage'><img title='View/Edit Page' src='images/document-edit.png' border='0' /></a></span>
	<span class='action_icon'><a href='index.php?ptype=addeditpage&id=".$row['id']."&action=deletepage' onclick=\"return confirm('Do you really want to delete this page?');\"><img border='0' title='Delete Page' src='images/delete.png' /></a></span></td></tr>";
}
	?>
</tbody></table>
<br />
<a class='btn btn-large' href='index.php?ptype=addeditpage&action=newpage'>Add New Page</a>
<?php 
}else print "<div class='alert alert-info'><h4 align='center'>No custom page found. Please <a href='index.php?ptype=addeditpage&action=newpage'><u>add a new one here</u></a>.</h4></div>";

}

function addNewPage(){
	include("config.php");
	if($isThisDemo=="no"){
	if(function_exists('set_magic_quotes_runtime')) @set_magic_quotes_runtime(0);
	if((function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc() == 1) || @ini_get('magic_quotes_sybase')) $_POST = remove_magic($_POST);
	$page_name=mysqli_real_escape_string($coni,strip_tags($_POST['pagename']));
	$page_content=mysqli_real_escape_string($coni,$_POST['bigdescription']);
	$page_order=mysqli_real_escape_string($coni,$_POST['pageorder']);
    $topmenu=mysqli_real_escape_string($coni,$_POST['topmenu']);
    $footermenu=mysqli_real_escape_string($coni,$_POST['footermenu']);
    $keywords=$_POST['keywords'];
	$dttm = date("Y-m-d H:i:s");
	if(trim($page_name)!=""){
	  $qr="insert into $pageTable (page_name,page_content,page_order,keywords,dttm,topmenu,footermenu) values ('$page_name','$page_content','$page_order','$keywords','$dttm','$topmenu','$footermenu')";
	  if(mysqli_query($coni,$qr)) print "<div class='alert alert-info'><h4 align='center' class='cmessage1'>Page added. <a href='index.php?ptype=addeditpage'><u>Go back</u></a>.</h5></div><Br />";
	  else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Page couldn't be added. <a href='javascript:history.go(-1)'><u>Go back</u></a>".mysqli_error()."</h5></div><Br />";
	}else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Please specify page name. <a href='javascript:history.go(-1)'><u>Go back</u></a></h5></div><Br />";	
	}else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Adding/Editing/Deleting Page is disabled in the demo.</div>";
}

function updatePage(){
	include("config.php");
	if($isThisDemo=="no"){
	 if(function_exists('set_magic_quotes_runtime')) @set_magic_quotes_runtime(0);
	 if((function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc() == 1) || @ini_get('magic_quotes_sybase')) $_POST = remove_magic($_POST);
	$id=mysqli_real_escape_string($coni,strip_tags($_POST['id']));
	$page_name=mysqli_real_escape_string($coni,strip_tags($_POST['pagename']));
	$page_content=mysqli_real_escape_string($coni,$_POST['bigdescription']);
	$page_order=mysqli_real_escape_string($coni,$_POST['pageorder']);
    $topmenu=mysqli_real_escape_string($coni,$_POST['topmenu']);
    $footermenu=mysqli_real_escape_string($coni,$_POST['footermenu']);
	$keywords=$_POST['keywords'];
	$dttm = date("Y-m-d H:i:s");
	if(trim($page_name)!=""){
		$qr="update $pageTable set page_name='$page_name',page_content='$page_content',page_order='$page_order',keywords='$keywords',dttm='$dttm', topmenu='$topmenu', footermenu='$footermenu' where id='$id'";
		if(mysqli_query($coni,$qr)) print "<div class='alert alert-info'><h4 align='center' class='cmessage1'>Page updated. <a href='index.php?ptype=addeditpage'><u>Go back</u></a>.</h5></div><Br />";
		else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Page couldn't be updated. <a href='javascript:history.go(-1)'><u>Go back</u></a>".mysqli_error()."</h5></div><Br />";
	}else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Please specify page name. <a href='javascript:history.go(-1)'><u>Go back</u></a></h5></div><Br />";
	}else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Adding/Editing/Deleting Page is disabled in the demo.</div>";
	
}

function addPageForm(){ ?>
<form name='addsoftwareform' action='index.php' method='post'>
<div class='pull-right'><b>Page Order</b><br><input type="text" class='span1' id="pageorder" name="pageorder" title="Specify page order i.e. where it would appear in the top menu." ></div>
<b>Page Name</b><Br />
<input type='text' name='pagename' id='pagename' size='55' title='This would appear in the top menu. So small name is recommended.' /><br /><br />
<b>Content</b><br />
<textarea id="bigdescription" name="bigdescription" rows="20" style="width: 80%" class="tinymce1">
</textarea>
<br />
<input type="checkbox" name='topmenu' value='1' /> <b>Show in the top menu</b><br />
<input type="checkbox" name='footermenu' value='1' /> <b>Show in the footer</b>
<br /><br />
<b>Keywords</b> <font size='1'>(enter a keyword and hit enter)</font><br />
<input name="keywords" id="keywords" value="" />
<input type='hidden' name='ptype' value='addeditpage' />
<input type='hidden' name='action' value='addpage' /><br /><br />
<input type='submit' id='publishpage' class='btn btn-large' value='Publish Page' />
</form>
<?php }

function editPageForm($id){ 
	include("config.php"); 
	$qr="select * from $pageTable where id='$id';";
	$result=mysqli_query($coni,$qr);
	$row=mysqli_fetch_assoc($result);
	?>

<form name='addsoftwareform' action='index.php' method='post'>
<div class='pull-right'><b>Page Order</b><br>
<input type="text" class='span1' id="pageorder" name="pageorder" value='<?php print $row['page_order']; ?>' title="Specify page order i.e. where it would appear in the top menu." ></div>
<b>Page Name</b><Br />
<input type='text' name='pagename' id='pagename' value='<?php print $row['page_name']; ?>' size='55' title='This would appear in the top menu. So small name is recommended.' /><br /><br />
<b>Content</b><br />
<textarea id="bigdescription" name="bigdescription" rows="20" style="width: 80%" class="tinymce1">
<?php print $row['page_content']; ?>
</textarea>
<br />
<input type="checkbox" name='topmenu' value='1' <?php if($row['topmenu']=="1"){ ?> checked="checked" <?php } ?> /> <b>Show in the top menu</b><br />
<input type="checkbox" name='footermenu' value='1' <?php if($row['footermenu']=="1"){ ?> checked="checked" <?php } ?>  /> <b>Show in the footer</b>
<br /><br />
<b>Keywords</b> <font size='1'>(enter a keyword and hit enter)</font><br />
<input name="keywords" id="keywords" value="<?php print $row['keywords']; ?>" />
<input type='hidden' name='ptype' value='addeditpage' />
<input type='hidden' name='id' value='<?php print $id; ?>' />
<input type='hidden' name='action' value='updatepage' /><br /><br />
<input type='submit' id='publishpage' class='btn btn-large' value='Update Page' />
<input type='button' id='publishpage' class='btn btn-large' onclick="history.go(-1)" value='Go Back' />
</form>

<?php }

function deletePage($id){
	include("config.php");	
	if($isThisDemo=="no"){
	$qr="delete from $pageTable where id='$id';";
	$result=mysqli_query($coni,$qr);
	if(mysqli_query($coni,$qr)) print "<div class='alert alert-info'><h4 align='center' class='cmessage1'>Page deleted. <a href='index.php?ptype=addeditpage'><u>Go back</u></a>.</h5></div><Br />";
	else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Page couldn't be deleted. <a href='javascript:history.go(-1)'><u>Go back</u></a>".mysqli_error()."</h5></div><Br />";
	}else print "<div class='alert alert-info'><h4 class='cmessage1' align='center'>Adding/Editing/Deleting Page is disabled in the demo.</div>";
}
?>
