<?php

function login_process($user_profile,$social_name=""){
    include("config.php");
    $coni=mysqli_connect($host, $username, $password)or die("cannot connect");
    mysqli_select_db($coni,$database)or die("cannot select DB");
    mysqli_query($coni,"SET NAMES utf8");
    $qr="select * from $rememberTable WHERE email='".$user_profile['email']."' and status='Active' ";
    $result=mysqli_query($coni,$qr);
    if($result && mysqli_num_rows($result)){
    $record=mysqli_fetch_assoc($result);
    if(trim($record['password'])=="") registration_process($user_profile,$social_name);
    else{
        if($record['open_identity']!=$_SESSION['openid_identity'] || $record['open_identity']==""){
          $qr2="update $rememberTable set open_identity='".$_SESSION['openid_identity']."' where email='".$user_profile['email']."'";
          $result2=mysqli_query($coni,$qr2);                
        }
        $_SESSION["re_mem_id"]=$record['id'];
        $_SESSION["memtype"]=$record['memtype'];
        $_SESSION["myusername"]=$record['username'];
        header("Location: index.php");
    } 
    }else{
        registration_process($user_profile,$social_name);
    }
    
    
}


function registration_process($user_profile,$social_name=""){
    include("config.php");
    ?>
<!DOCTYPE html>
<html>
<head>
<title><?php print $browsertitle; ?> - Login using <?php print $social_name; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" language="javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="loadingImage.js"></script>
<script type="text/javascript" language="javascript" src="infoResults.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/<?php print $webtheme; ?>/bootstrap.css" />
<link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
$(function(){
    <?php if($fixedtopheader=="yes"){ ?>
     var topbarHeight=$('.navbar').height();
     $('body').css('padding-top',topbarHeight+'px');
     <?php } ?>
    
    $("#registerButton").click(function(){
    var reusername=$("input#reusername").val();
    if ((reusername==null)||(reusername.length<4)){
        alert("<?php print $relanguage_tags["Please enter your"]." ".$relanguage_tags["Username"];?> (<?php print $relanguage_tags["at least"]." 4 ".$relanguage_tags["characters"];?>).")
        return false
    }
    return true;
    });
            
});
</script>
</head>
<body>
<div class="navbar navbar-default <?php if($fixedtopheader=="yes") print "navbar-fixed-top"; ?>">
    <div class="navbar-inner">
    <?php $brandShown=false; if(($ptype=="showOnMap" && $_GET['fullscreen']=="true") || $fullScreenEnabled=="true"){ 
        if(trim($autoadmin_settings['websitelogo'])!=""){ ?>
        <div id='logo'><a style="margin-left:5px;" href="<?php print $full_url_path; ?>"><img src='uploads/<?php print $autoadmin_settings['websitelogo']; ?>' /></a></div>
        <?php }else{ ?>
        <a class="brand" style="margin-left:5px;" href="<?php print $full_url_path; ?>"><?php print $reSiteName; ?></a>
    <?php  } $brandShown=true; } ?>
    <div class="menuside pull-right"><ul class="nav pull-right"><li><a href="rss.php"><img border="0" src="images/rss.png"></a></li></ul></div>
    <?php if(!$brandShown){ ?><div class="container"> <?php  } ?>
    
    <?php if(!$brandShown){ 
           if(trim($autoadmin_settings['websitelogo'])!=""){ ?>
           <div id='logo'><a href="<?php print $full_url_path; ?>"><img src='uploads/<?php print $autoadmin_settings['websitelogo']; ?>' /></a></div>
           <?php }else{ ?>
           <a class="brand" href="<?php print $full_url_path; ?>"><?php print $reSiteName; ?></a> 
    <?php } } ?>
    <?php if(trim($autoadmin_settings['websitelogo'])!=""){ ?>
  <!--  <div id='logo'></div> --> 
   <?php }else{ ?>
   <h1><?php print $autoadmin_settings['websitetitle']; ?></h1>
   <?php } ?>
   <?php  if(trim($toplinkad)!=""){ ?>
   <div style="float:left; margin:10px auto 0 40px;" id="top_ad_menu"><?php print $toplinkad; ?></div>
    <?php } ?>
    
    <div class="nav-collapse pull-right">
    <ul class="nav navbar-nav">
    <li class='first_item'><a href='index.php'><?php print $relanguage_tags["Home"];?></a></li>
    <li><a href='index.php?ptype=contactus'><?php print $relanguage_tags["Contact us"];?></a></li>
    </ul>
    </div> <!-- nav-collapse -->
    <?php if(!$brandShown){ ?></div> <!-- container --> <?php  } ?>
  
    </div> <!-- navbar-inner -->
  </div>  <!-- navbar -->
  
 <br /><br />
<h3 align='center'><?php print $relanguage_tags["Almost done"];?></h3>
<br />
<?php
$actionUrl="fblogin.php";
if($social_name=="facebook") $actionUrl="fblogin.php";
if($social_name=="Google") $actionUrl="glogin.php";
if($social_name=="Yahoo") $actionUrl="ylogin.php";
?>
<form id="registerForm" name="registerForm" class="registerForm"  method="post" action="<?php print $actionUrl; ?>">
    <div class="control-group" style="text-align:center;">
    <label class="control-label" for="myusername"><b><?php print $relanguage_tags["Username"];?></b></label>
     <div class="controls">
     <input id="reusername"  name="myusername" size='20'  type="text" maxlength="255" value="<?php print $user_profile['username']; ?>" onblur="infoResults(this.value,5,'usernameMessage');"  />
     <input id="reemail"  name="myemail" size='20' type="hidden" maxlength="255" value="<?php print $user_profile['email']; ?>" />
     <input id="reemail"  name="myname" size='20' type="hidden" maxlength="255" value="<?php print $user_profile['name']; ?>" />
     <br /><div id='usernameMessage'></div>
     <p class="help-block"><?php print $relanguage_tags["You can choose a different username for"]; ?> <b><?php print $reSiteName; ?></b></p>
     </div>
    </div>
    <div class="control-group" style="text-align:center;">
    <div class='controls'><input id="registerButton"  class='btn' type="submit" name="register" value="<?php print $relanguage_tags["Register"]; ?>" /></div>
    </div>
</form> 
</body>
</html> 
    
    <?php 
}

function finish_registration($social_name=""){
    include("config.php");
    ?>
<!DOCTYPE html>
<html>
<head>
<title><?php print $browsertitle; ?> - Login using <?php print $social_name; ?></title>
<body>
    <?php 
    include("config.php");
    $myname=$_POST['myname'];
    $myusername=$_POST['myusername'];
    $myemail=$_POST['myemail'];
    //$mypassword=$_POST['mypassword'];
    $mytextpassword=randString(8);
    $mypassword=md5($mytextpassword);
    $str_today = date("Y-m-d");
    $ip=$_SERVER["REMOTE_ADDR"];
    $open_identity=$_SESSION['openid_identity'];
    
    $coni=mysqli_connect($host, $username, $password)or die("cannot connect");
    mysqli_select_db($coni,$database)or die("cannot select DB");
    mysqli_query($coni,"SET NAMES utf8");
    $qr="insert into $rememberTable (name,username,password,email,dttm,ip,open_identity) values ('$myname','$myusername','$mypassword','$myemail','$str_today','$ip','$open_identity')";
    if(mysqli_query($coni,$qr)){
        include_once("functions.inc.php");
        sendPassword($myemail,'register',$mytextpassword);
        print "<h3 align='center'>".$relanguage_tags["Registration successful"]."</h3>";
        
        $qr1="select * from $rememberTable WHERE email='$myemail'";
        $result=mysqli_query($coni,$qr1);
        if($result){
        $record=mysqli_fetch_assoc($result);
        $_SESSION["re_mem_id"]=$record['id'];
        $_SESSION["memtype"]=$record['memtype'];
        $_SESSION["myusername"]=$record['username'];
        }
        ?>
        <h5 align='center'><a href='index.php'><?php print $relanguage_tags["Go back"]; ?></a>.</h5>
                <?php 
            }else{
             print "<h4 align='center'>".$relanguage_tags["Registration failed"].".</h4>";
             if(mysqli_errno()==1062){
              print "<h5 align='center'>".$relanguage_tags["Account associated with"]." $reemail or $reusername ".$relanguage_tags["already exists"].".";
             ?>
             <br /><a href='index.php'><?php print $relanguage_tags["Please try again"]; ?></a>.
             <?php 
              print"</h5>";
             }else print "<h5 align='center'>".mysqli_error()."</h5>"; 
            }
        ?>
</body></html>
        <?php 
}

function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}



?>