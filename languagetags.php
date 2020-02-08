<?php 
if($memtype==9){
include("config.php");
    $con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
    mysqli_select_db($coni,$database);
    mysqli_query($coni,"SET NAMES utf8");
    
    if($ptype=="updateLanguageTags"){
        include_once("functions.inc.php");
        if(function_exists('set_magic_quotes_runtime')) @set_magic_quotes_runtime(0);
        if((function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc() == 1) || @ini_get('magic_quotes_sybase')) $_POST = remove_magic($_POST);
        
        if($_GET["laction"]=="delete"){
            $tagid=$_GET['lid'];
            $qr0="delete from $languageTable where id='$tagid'";
            if($isThisDemo!="yes") $result0=mysqli_query($coni,$qr0);
        }else{
        foreach($_POST as $inputname => $translation) {
            list($temp,$tagid)=explode("-",$inputname);
            $translation=addslashes(trim($translation));
            //print "$tagid - $inputname = $translation<Br />";
            $qr0="update $languageTable set translation='$translation' where id='$tagid'";
            if($isThisDemo!="yes") $result0=mysqli_query($coni,$qr0);
        }
      }         
    }
    
    $qr="select id, keyword, translation from $languageTable where language='$redefaultLanguage'";
    $result=mysqli_query($coni,$qr);
    while($langOptions=mysqli_fetch_assoc($result)){
        $languageTags[$langOptions['keyword']]=$langOptions['translation'];
        $idTags[$langOptions['keyword']]=$langOptions['id'];
    }
    $_SESSION["cl_language"]=$languageTags;
    //mysqli_data_seek($result,0);
    
?>
<div id='perimeter'>
<fieldset id='reProfilePage'>
<legend>
<b><?php print $relanguage_tags["Language tags"];?></b>
</legend>
    <div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
    <h4 class="alert-heading">Help</h4>
    The website default language is set to <?php print $redefaultLanguage; ?> so the keywords and their translations are in <?php print $redefaultLanguage; ?>.
Keywords are basically labels used on this website. So if you want to change a keyword/label <b>Category</b> to <b>Brand</b>, then you just need to update the translation of 
<b>Category</b> to <b>Brand</b> and the word <b>Brand</b> would appear across the site instead of the word <b>Category</b>.
    </div>
<p align='center'><font size='1'></font></p>
<table id='resultTable'>
<tr class='headRow1'><td><b><?php print $relanguage_tags["Keyword"];?></b> (English)</td>
<td><b><?php print $relanguage_tags["Translation"];?></b> (<?php print $redefaultLanguage; ?>)</td>
</tr>
<tr><td>
<input type='text' size='25' name='newtag' id='newtag' /></td>
<td><input type='text' size='25' name='newtranslation' id='newtranslation' />
<input type='button' id='addNewTag' class='btn' value='Add a new translation'  style="margin-bottom:9px;" />
</td>
<tr><td colspan='2' align='center'><div id='addTagStatus'></div></td></tr>
</tr>
</table>
<Br /><br />
<form action="index.php" method="post" enctype="multipart/form-data" name='imgform' >
<table id='resultTable'>
<tr class='headRow1'><td><b><?php print $relanguage_tags["Keyword"];?></b> (English)</td>
<td><b><?php print $relanguage_tags["Translation"];?></b> (<?php print $redefaultLanguage; ?>)</td>
</tr>
<?php 
$totalTags=1;
//while($tag=mysqli_fetch_assoc($result)){
foreach($languageTags as $keyword => $translation){
$transID="trans-".$idTags[$keyword];
$imageID="update-".$idTags[$keyword];
$tdID="keyword-".$idTags[$keyword];   
$divID="langResult-".$idTags[$keyword];  
print "<tr><td style='width:60%;' id='$tdID'>".$keyword."</td><td><input type='text' size='65' name='$transID' id='$transID' value='".htmlspecialchars($translation, ENT_QUOTES)."' />
<span style='margin-left:5px;cursor:pointer;'><img class='updateLangTag' title='Update language tag' id='$imageID' border='0' src='images/update-product.png' /></span><span style='margin-left:5px;'><a onClick=\"if(confirm('Delete the keyword ($keyword) and its translation?')) return true; else return false;\" href='?ptype=updateLanguageTags&laction=delete&lid=".$idTags[$keyword]."'><img class='deleteLangTag' title='Delete language tag'  border='0' src='images/cross-circle.png' /></a></span>
<div id='$divID'></div>
</td></tr>";
$totalTags++;
}
?>
<tr><td colspan='2' align='center'>
<input type='hidden' name='totaltags' value='<?php print $totalTags; ?>' />
<input type='hidden' name='ptype' value='updateLanguageTags' />
<input type='hidden' name='defLang' id='defLang' value='<?php print $redefaultLanguage; ?>' />
<input style='display:none;' type='submit' name='submit' id='languageUpdateButton' class='btn btn-large btn-primary' value='Update' /></td></tr>
</table>
</form>
</fieldset>
</div>
<?php  } ?>