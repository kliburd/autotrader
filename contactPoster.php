<?php 
error_reporting(0);
include("config.php");
include_once("functions.inc.php");
require_once('recaptcha/recaptchalib.php');
$reid=trim($_GET["reid"]);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<script type="text/javascript" language="javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
$(function(){
var h = $(window).height();
var w = $(window).width();
    
$('#visitor_submit').click(function(){
var visitor_name=$.trim($('input#visitor_name').val()); 
var visitor_email=$.trim($('input#visitor_email').val());
var visitor_message=$.trim($('#visitor_message').val());
var errorMessage="<?php print $relanguage_tags["Please specify"];?>: ";
$prevLen=errorMessage.length;
if(visitor_name.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Name"];?>";
if(visitor_email.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Email"];?>";
if(visitor_message.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Message"];?>";
if(errorMessage.length>$prevLen){
    alert(errorMessage);
    return false;
}else{
    return true;
   }
});
    
});
</script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/bootstrap.css" />
<?php
if($_SESSION["rtl"]){ ?>
<link href="css/rtl_style.php?ptype=<?php print $ptype; ?>&amp;fullscreen=<?php print $_GET["fullscreen"]; ?>&amp;fs=<?php print $fullScreenEnabled; ?>"
rel="stylesheet" type="text/css" />
<style> body {direction: rtl;}</style>
<?php } ?>
</head>
<body style="background-color:#ffffff;">
<div class='container'>
   <div class='row'>  
         <div class='col-md-1 col-lg-1'></div>
         <div class='col-md-10 col-lg-10'>
             <h3 align='center'><?php print __("Contact Poster")." ".__("of")." ".__("listing");?> # <?php print $reid; ?></h3><br />
              <form name='contactForm' method='post' action='sendMessage.php' class="form-horizontal">
        <div class="form-group">
            <label class="col-md-2 col-lg-2  <?php if($_SESSION['rtl']!=true) print " control-label "; ?> " for="visitor_name"><span class='required_field' <?php if($_SESSION['rtl']==true) print " style='float:left;' "; ?> ><sup>*<sup></span><b><?php print __("Name");?>:</b></label>
            <div class="col-md-10 col-lg-10">
            <input type='text' class='form-control' id='visitor_name' name='visitor_name'>
            </div> 
        </div>

        <div class="form-group">
            <label class="col-md-2 col-lg-2  <?php if($_SESSION['rtl']!=true) print " control-label "; ?> " for="visitor_name"><span class='required_field' <?php if($_SESSION['rtl']==true) print " style='float:left;' "; ?> ><sup>*<sup></span><b><?php print __("Email");?>:</b></label>
            <div class="col-md-10 col-lg-10">
                <input type='text' class='form-control' id='visitor_email' name='visitor_email'>
            </div> 
        </div>
        
        <div class="form-group">
            <label class="col-md-2 col-lg-2  <?php if($_SESSION['rtl']!=true) print " control-label "; ?> " for="visitor_name"><span class='required_field' <?php if($_SESSION['rtl']==true) print " style='float:left;' "; ?> ><sup>*<sup></span><b><?php print __("Message");?>:</b></label>
             <div class="col-md-10 col-lg-10">
            <textarea name='visitor_message' id='visitor_message' class='form-control' rows='5'></textarea>
            </div> 
        </div>
        
        <?php if(trim($reCaptchaPublicKey)!=""){ ?>
        <div class="form-group">
            <div class="col-md-2 col-lg-2"></div>
            <div class="col-md-10 col-lg-10">
              <div class="g-recaptcha" data-sitekey="<?php print $reCaptchaPublicKey; ?>"></div>
            </div>
         </div>   
         <?php } ?>
         
        <div class="form-group" style="clear:both; float:right;">
            <div class="controls">
              <input type='hidden' name='reid' value='<?php print $reid; ?>' />
              <input type='submit' class='btn btn-primary btn-lg' value='<?php print __("Submit");?>' id='visitor_submit' />
            </div> 
        </div>
</form>  
         </div>
    <div class='col-md-1 col-lg-1'></div>
  </div> <!-- end row -->
</div> <!-- end container -->
</body>
</html>