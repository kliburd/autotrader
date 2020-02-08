<?php if($memtype==9){ ?>
<div id='rememberAction'>
<form name='adminOptionForm' method='post' action='index.php'>
<table id='resultTable'>
<tr class='headRow1'><td colspan='7'><b>Member management</b></td></tr>
<tr>
<td>ID</td>
<td>Username</td>
<td>Name</td>
<td>Email</td>
<td>Phone</td>
<td>Status</td>
</tr>
<?php 
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$qr1="select * from $rememberTable";
$result1=mysqli_query($coni,$qr1);

while ($allMembers=mysqli_fetch_assoc($result1)){
if($allMembers['status']=="Ban") $memClass= " bannedMember "; 
else $memClass="";

print "<tr class='allmembers $memClass'>";
print "<td>".$allMembers['id']."</td>";
print "<td>".$allMembers['username']."</td>";
print "<td>".$allMembers['name']."</td>";
print "<td>".$allMembers['email']."</td>";
print "<td>".$allMembers['phone']."</td>";
print "<td><div id='memberstatus".$allMembers['id']."'>";
?>
<?php if($isThisDemo!="yes"){ ?>
<select name='memberstatus<?php print $allMembers['id']; ?>' onchange="if(confirm('Please confirm that you wish to change status of member # <?php print $allMembers['id']; ?>?')) infoResults(this.value+'<?php print "::".$allMembers['id']; ?>',13,'memberstatus<?php print $allMembers['id']; ?>');" >
<?php  }else{ ?>
<select name='memberstatus<?php print $allMembers['id']; ?>' onchange="alert('Changing member status has been disabled in demo');" >
<?php  } ?>
<option value='Active' <?php if($allMembers['status']=="Active") print " selected='selected'"; ?> >Active</option>
<option value='Ban'  <?php if($allMembers['status']=="Ban") print " selected='selected'"; ?> >Ban</option>
<option value='Delete' >Delete</option>
</select>
<?php 
print "</div></td>";
print "</tr>";

}
mysqli_close();
?>
</table>
</form>
</div>
<?php  } ?>