<?php require_once('recaptcha/recaptchalib.php'); ?>
<table id='resultTable'><tr><td class='headRow1'><h3><?php print $relanguage_tags["Contact us"];?></h3></td></tr>
<tr><td class='spltd'>

<?php if(trim($contactaddress)!="") print "<br /><h3 align='center'>".$relanguage_tags["Address"]."</h3><p align='center'>".nl2br($contactaddress)."</p>"; ?>
<br />
<div id='contactpage'>
<?php if(trim($contactformemail)!=""){ ?>
<h3 align='center'><?php print $relanguage_tags["Send us a message"];?></h3>
<form name='contactForm' method='post' action='sendMessage.php'>
        <div class='container-fluid'>
        
        <div class='row' style="margin-bottom:10px;"><div class='col-md-4 col-lg-4 sbar'><b><?php print $relanguage_tags["Name"];?>:</b></div><div class='col-md-8 col-lg-8 infield'><input type='text' size='30' id='visitor_name' name='visitor_name' class='col-xs-12 col-sm-12 col-md-12 col-lg-12'></div></div>
        <div class='row' style="margin-bottom:10px;"><div class='col-md-4 col-lg-4 sbar'><b><?php print $relanguage_tags["Email"];?>:</b></div><div class='col-md-8 col-lg-8 infield'><input type='text' size='30' id='visitor_email' name='visitor_email' class='col-xs-12 col-sm-12 col-md-12 col-lg-12'></div></div>
        <div class='row' style="margin-bottom:10px;"><div class='col-md-4 col-lg-4 sbar'><b><?php print $relanguage_tags["Message"];?></b></div><div class='col-md-8 col-lg-8 infield'><textarea name='visitor_message' id='visitor_message' cols='37' rows='7' class='col-xs-12 col-sm-12 col-md-12 col-lg-12'></textarea></div></div>
        <?php if(trim($reCaptchaPublicKey)!=""){ ?>
        <div class='row' style="margin-bottom:10px;">
        <div class='col-md-4 col-lg-4'></div>    
        <div class='col-md-6 col-lg-6 sbar'>
        <div class="g-recaptcha" data-sitekey="<?php print $reCaptchaPublicKey; ?>"></div>
        </div>
        </div>
        <?php } ?>
        <div class='row' style="margin-bottom:10px;"><div class='col-md-4 col-lg-4 sbar'></div><div class='col-md-8 col-lg-8'><input type='hidden' name='reid' value='contactuspage' />
        <input type='hidden' name='debug' value='yes' />
        <input type='submit' class='btn btn-lg btn-primary' value='<?php print $relanguage_tags["Submit"];?>' id='visitor_submit' /></div></div>
        </div>        
</form>
<?php }else print "<p align='center'>Please specify contact us email under 'Contact us' tab on 'Admin options' page and a contact form would appear here.</p><br /><br />"; ?>
</div>
</td></tr></table>
