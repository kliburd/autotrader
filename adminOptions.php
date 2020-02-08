<?php if($memtype==9){ ?>
<div id='rememberAction'>
<?php include("updateAdminOptions.php"); ?>
<form name='adminOptionForm' method='post' action='index.php' enctype="multipart/form-data" >
<table id='resultTable' class='table'>
<tr class='headRow1'><td colspan='2'><b>Admin Options (<?php print $version_num; ?>) <font size='1'><a class="label label-success" href='<?php print $changelog; ?>' target='_blank'>changelog here</a>  <a  class="label label-info" href='http://www.codiator.com/Auto-Trading-Made-Easy/Help/' target='_blank'>documentation here</a> <a  class="label label-inverse" href='http://codecanyon.net/item/auto-trading-made-easy/1897428/support' target='_blank'>faq here</a></font></b></td></tr>

<tr>
<td class='admintd' width='100%'>
<h4>Theme & General colors</h4>
<div class='newline1'></div>
<div class='pull-right webscreen'></div>
<div class='adminlabel'>Choose website theme:</div>  
<select name='webtheme' id='rewebTheme' >
            <option value='default' <?php if($webtheme=="default" || $webtheme=="") print " selected='selected' "; ?> >Default</option>
                <option value='amelia' <?php if($webtheme=="amelia") print " selected='selected' "; ?> >Amelia</option>
                <option value='cerulean' <?php if($webtheme=="cerulean") print " selected='selected' "; ?> >Cerulean</option>
                <option value='cosmos' <?php if($webtheme=="cosmos") print " selected='selected' "; ?> >Cosmos</option>
                <option value='cyborg' <?php if($webtheme=="cyborg") print " selected='selected' "; ?> >Cyborg</option>
                <option value='flatly' <?php if($webtheme=="flatly") print " selected='selected' "; ?> >Flatly</option>
                <option value='journal' <?php if($webtheme=="journal") print " selected='selected' "; ?> >Journal</option>
                <option value='readable' <?php if($webtheme=="readable") print " selected='selected' "; ?> >Readable</option>
                <option value='simplex' <?php if($webtheme=="simplex") print " selected='selected' "; ?> >Simplex</option>
                <option value='slate' <?php if($webtheme=="slate") print " selected='selected' "; ?> >Slate</option>
                <option value='spacelab' <?php if($webtheme=="spacelab") print " selected='selected' "; ?> >Spacelab</option>
                <option value='united' <?php if($webtheme=="united") print " selected='selected' "; ?> >United</option>
                <option value='yeti' <?php if($webtheme=="yeti") print " selected='selected' "; ?> >Yeti</option>
                <option value='custom' <?php if($webtheme=="custom") print " selected='selected' "; ?> >Custom</option>
</select>
<div class='newline1'></div>
<div class='adminlabel'>Choose site outer background color:</div> <input type='text' name='siteoutercolor' value='<?php print $adminOptions['siteoutercolor']; ?>' id='siteOuterColor' size='10' />
<div class='newline1'></div>
<!-- <div class='adminlabel'>Choose site header background color:</div> <input type='text' name='siteheadercolor' value='<?php print $adminOptions['siteheadercolor']; ?>'  id='siteHeaderColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose site header font color:</div> <input type='text' name='siteheaderfontcolor' value='<?php print $adminOptions['siteheaderfontcolor']; ?>'  id='siteHeaderFontColor' size='10' />
<div class='newline1'></div> -->
<div class='adminlabel'>Choose site inner background color:</div> <input type='text' name='siteinnercolor' value='<?php print $adminOptions['siteinnercolor']; ?>'  id='siteInnerColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Fixed top header?</div> <input type='checkbox' name='fixedtopheader' value='yes' <?php if($fixedtopheader=="yes"){ ?> checked="checked" <?php } ?> />
<div class='newline1'></div>
<!--<div class='adminlabel'>Choose site border color:</div> <input type='text' name='sitebordercolor' value='<?php print $adminOptions['sitebordercolor']; ?>'  id='siteBorderColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose site footer font color:</div> <input type='text' name='sitefooterfontcolor' value='<?php print $adminOptions['sitefooterfontcolor']; ?>'  id='sitefooterfontcolor' size='10' />
<div class='newline1'></div> -->
</td>
</tr>
<!-- 
<tr>
<td class='admintd' width='100%'>
<h4>Top menu</h4>
<div class='newline1'></div>
<div class='adminlabel'>Choose top menu background color:</div> <input type='text' name='topmenubackgroundcolor' value='<?php print $adminOptions['topmenubackgroundcolor']; ?>'  id='topmenubackgroundcolor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose top menu border color:</div> <input type='text' name='topmenubordercolor' value='<?php print $adminOptions['topmenubordercolor']; ?>'  id='topmenubordercolor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose top menu font color:</div> <input type='text' name='topmenufontcolor' value='<?php print $adminOptions['topmenufontcolor']; ?>'  id='topmenufontcolor' size='10' />
<div class='newline1'></div>
</td>
</tr>
-->
<tr>
<td class='admintd' width='100%'>
<h4>Search form</h4>
<div class='newline1'></div>
<div class='adminlabel'>Choose search form color:</div> <input type='text' name='searchformcolor' value='<?php print $adminOptions['searchformcolor']; ?>'  id='searchFormColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose search form border color:</div> <input type='text' name='searchformbordercolor' value='<?php print $adminOptions['searchformbordercolor']; ?>'  id='searchFormBorderColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose search form font color:</div> <input type='text' name='searchformfontcolor' value='<?php print $adminOptions['searchformfontcolor']; ?>'  id='searchFormFontColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose search form field theme:</div>  
<select name='fieldtheme' id='refieldTheme' >
          	<option value='base' <?php if($fieldtheme=="base" || $fieldtheme=="") print " selected='selected' "; ?> >base</option>
    	    	<option value='black-tie' <?php if($fieldtheme=="black-tie") print " selected='selected' "; ?> >black-tie</option>
    	    	<option value='blitzer' <?php if($fieldtheme=="blitzer") print " selected='selected' "; ?> >blitzer</option>
    	    	<option value='cupertino' <?php if($fieldtheme=="cupertino") print " selected='selected' "; ?> >cupertino</option>
    	    	<option value='dark-hive' <?php if($fieldtheme=="dark-hive") print " selected='selected' "; ?> >dark-hive</option>
    	    	<option value='dot-luv' <?php if($fieldtheme=="dot-luv") print " selected='selected' "; ?> >dot-luv</option>
    	    	<option value='eggplant' <?php if($fieldtheme=="eggplant") print " selected='selected' "; ?> >eggplant</option>
    	    	<option value='excite-bike' <?php if($fieldtheme=="excite-bike") print " selected='selected' "; ?> >excite-bike</option>
    	    	<option value='flick' <?php if($fieldtheme=="flick") print " selected='selected' "; ?> >flick</option>
    	    	<option value='hot-sneaks' <?php if($fieldtheme=="hot-sneaks") print " selected='selected' "; ?> >hot-sneaks</option>
    	    	<option value='humanity' <?php if($fieldtheme=="humanity") print " selected='selected' "; ?> >humanity</option>
    	    	<option value='le-frog' <?php if($fieldtheme=="le-frog") print " selected='selected' "; ?> >le-frog</option>
    	    	<option value='mint-choc' <?php if($fieldtheme=="mint-choc") print " selected='selected' "; ?> >mint-choc</option>
    	    	<option value='overcast' <?php if($fieldtheme=="overcast") print " selected='selected' "; ?> >overcast</option>
    	    	<option value='pepper-grinder' <?php if($fieldtheme=="pepper-grinder") print " selected='selected' "; ?> >pepper-grinder</option>
    	    	<option value='redmond' <?php if($fieldtheme=="redmond") print " selected='selected' "; ?> >redmond</option>
    	    	<option value='smoothness' <?php if($fieldtheme=="smoothness") print " selected='selected' "; ?> >smoothness</option>
    	    	<option value='south-street' <?php if($fieldtheme=="south-street") print " selected='selected' "; ?> >south-street</option>
    	    	<option value='start' <?php if($fieldtheme=="start") print " selected='selected' "; ?> >start</option>
    	    	<option value='sunny' <?php if($fieldtheme=="sunny") print " selected='selected' "; ?> >sunny</option>
    	    	<option value='swanky-purse' <?php if($fieldtheme=="swanky-purse") print " selected='selected' "; ?> >swanky-purse</option>
    	    	<option value='trontastic' <?php if($fieldtheme=="trontastic") print " selected='selected' "; ?> >trontastic</option>
    	    	<option value='ui-darkness' <?php if($fieldtheme=="ui-darkness") print " selected='selected' "; ?> >ui-darkness</option>
    	    	<option value='ui-lightness' <?php if($fieldtheme=="ui-lightness") print " selected='selected' "; ?> >ui-lightness</option>
    	    	<option value='vader' <?php if($fieldtheme=="vader") print " selected='selected' "; ?> >vader</option>
    

</select>
<div class='newline1'></div>
</td>
</tr>

<tr>
<td class='admintd' width='100%'>
<h4>Lower sidebar</h4>
<div class='newline1'></div>
<div class='adminlabel'>Choose lower sidebar color:</div> <input type='text' name='menuboxcolor' value='<?php print $adminOptions['menuboxcolor']; ?>'  id='menuBoxColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose lower sidebar font color:</div> <input type='text' name='menuboxfontcolor' value='<?php print $adminOptions['menuboxfontcolor']; ?>'  id='menuBoxFontColor' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Choose lower sidebar border color:</div> <input type='text' name='menuboxbordercolor' value='<?php print $adminOptions['menuboxbordercolor']; ?>'  id='menuBoxBorderColor' size='10' />
<div class='newline1'></div>

</td>
</tr>

<tr>
<td class='admintd' width='100%'>
<h4>General options <span class='headinginfo'>(all settings under this section are recommended)</span></h4>
<div class='newline1'></div>
<div class='adminlabel'>Website heading:</div> <input type='text' name='websitetitle' value='<?php print $adminOptions['websitetitle']; ?>'  id='websiteTitle' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Select Logo: <font size='1'>(optional)</font></div> <input type="file" name="photoimg" id="photoimg" class='rebutton' />
<?php if($adminOptions['websitelogo']!=""){ ?>
<div class='newline1'></div>
<div class='adminlabel'>Current Logo:</div><img src="uploads/<?php print $adminOptions['websitelogo']; ?>" border="0" />&nbsp;&nbsp;&nbsp;&nbsp;
Remove logo? <input type='checkbox' name='removewebsitelogo' value='yes' />
<?php } ?>
<div class='newline1'></div>
<div class='adminlabel'>Website footer:<br /><font size='1'>(html allowed)</font></div> <textarea name='websitefooter' cols='40' rows='3'><?php print $adminOptions['websitefooter']; ?></textarea>
<div class='newline1'></div>
<div class='adminlabel'>Default country:</div> <input type='text' name='defaultcountry' value='<?php print $adminOptions['defaultcountry']; ?>'  id='defaultCountry' size='30' />
<div class='newline1'></div>
<div class='adminlabel'>Default currency:</div> <input type='text' name='defaultcurrency' value='<?php print $adminOptions['defaultcurrency']; ?>'  id='defaultCurrency' value='$' size='3' />
<div class='newline1'></div>
<div class='adminlabel'>Default language:</div> <select name='defaultlanguage' id='reLanguage' >
<?php include("languageOptions.php"); ?>
</select>
<div class='newline1'></div>
<div class='adminlabel'>Auto delete listings which are not marked as <u>permanent</u> after:</div> <input class='span1' type='text' name='delete_after_days' value='<?php print $adminOptions['delete_after_days']; ?>'  id='delete_after_days' value='' size='3' /> days <font size='1'>(leave it blank or 0 to never delete any listing)</font>

<div class='newline1'></div>
<div class='adminlabel'>Google Maps API Key:<sup><span class='smallOptional'><a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>get it here</a></span></sup></div> <input type='text' name='googlemapapikey' value='<?php print $adminOptions['googlemapapikey']; ?>'  id='googlemapapikey' size='50' />


<div class='newline1'></div>
<div class='adminlabel'>Splash Page:</div> 
<select name='splashpage'>
    <option value='' <?php if(trim($adminOptions['splashpage'])=="")print " selected='selected' "; ?> >None</option>
    <?php
    foreach(scandir("splash") as $filename) {
        if ($filename !== '.' AND $filename !== '..' ) { ?>
<option value='<?php print $filename; ?>' <?php if($adminOptions['splashpage']==$filename)print " selected='selected' "; ?>><?php print $filename; ?></option>   
        <?php }
    }
    ?>
</select>
<div class='newline1'></div>

<div class='adminlabel'>Enable map mode for the main listing page?:</div> <input type='checkbox' name='fullscreenenabled' value='true' <?php if($adminOptions['fullscreenenabled']=="true") print " checked='yes' "?> />
<div class='newline1'></div>

<div class='adminlabel'>Enable Registration Captcha?:</div> <input type='checkbox' name='enableregistercaptcha' value='1' <?php if($adminOptions['enableregistercaptcha']==1) print " checked='yes' "?> />
<div class='newline1'></div>

<div class='adminlabel'>Enable RTL mode (for languages such as arabic, hebrew)?:</div> <input type='checkbox' name='rtl' value='1' <?php if($adminOptions['rtl']==1) print " checked='yes' "?> />
<div class='newline1'></div>

<div class='adminlabel'>Enable Google Login?:</div> <input type='checkbox' name='googlelogin' value='1' <?php if($adminOptions['google_login']==1) print " checked='yes' "?> />
<div class='newline1'></div>

<div class='adminlabel'>Enable Yahoo Login?:</div> <input type='checkbox' name='yahoologin' value='1' <?php if($adminOptions['yahoo_login']==1) print " checked='yes' "?> />
<div class='newline1'></div>

<div class='adminlabel'>Show currency symbol before price?:</div> <input type='checkbox' name='currencybeforeprice' value='1' <?php if($adminOptions['currency_before_price']==1) print " checked='yes' "?> />
<div class='newline1'></div>

<div class='adminlabel'>Enable GeoIP?</div> <input type='checkbox' name='geoipenable' value='yes' <?php if($adminOptions['geoipenable']=="yes"){ ?> checked="checked" <?php } ?> />
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
    Version 1.3 and above supports thousands of markers without any performance issue. A single markers is composed up of merely 32 bytes so loading 10,000 markers would mean loading only 320 kb of marker data and 50,000 markers would be merely 1.6 mb of data.<br /><br />
    If you enable GeoIP, all the markers would be loaded but map would be zoomed to viewer's location (based on the IP address) even if there's no marker to show.
    <br />
    If you <u>do not</u> enable GeoIP feature, the script would still load all markers and map bounds would automatically be adjusted to fit those markers. So if there are listings only in a single city then map would zoom to that city only, irrespective to viewer's location. If there are listing in entire country, the map would adjust its bounds to cover all the marker i.e. show the country irrespective to viewer's actual location.
 
</div>
<div class='newline1'></div>
<div class='adminlabel'>reCaptcha Private Key:<sup><span class='smallOptional'><a target='_blank' href='https://www.google.com/recaptcha/admin/create'>get it here</a></span></sup></div> <input type='text' name='recaptchaprivatekey' value='<?php print $adminOptions['recaptchaprivatekey']; ?>'  id='recaptchaprivatekey' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>reCaptcha Public Key:<sup><span class='smallOptional'><a target='_blank' href='https://www.google.com/recaptcha/admin/create'>get it here</a></span></sup></div> <input type='text' name='recaptchapublickey' value='<?php print $adminOptions['recaptchapublickey']; ?>'  id='recaptchapublickey' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Enable friendly URLs?:</div> <input type='checkbox' name='refriendlyurl' value='enabled' <?php if($adminOptions['refriendlyurl']=="enabled") print " checked='yes' "?> id='refriendlyURL' />
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
    If you see 'Page not found' error after enabling <b>friendly URL</b> option, then disable it and ask your hosting provider to enable <b>.htaccess</b> rewrite rules. Friendly URLs won't work if <b>mod rewrite</b> is diabled or <b>'Allowoverride' directive</b> is set to <b>none</b> in your web server/virtual host configuration. 
    </div>
<div class='newline1'></div>
<div class='adminlabel' id='htaccessInfo'>Paste this in .htaccess:<br /><font size='1'>(and click 'update options' button below)</font></div> <textarea id='rehtaccessinfo' name='rehtaccessinfo' cols='40' rows='5'>
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteRule ^id-([^/\.]+)/?$ index.php?ptype=viewFullListing&reid=$1 [L]
</IfModule>
</textarea>
<div class='newline1'></div>

<!-- 
<div class='adminlabel'>Akismet API Key:<sup><span class='smallOptional'><a target='_blank' href='https://akismet.com/signup/'>get it here</a></span></sup></div> <input type='text' name='wordpressapikey' value='<?php print $adminOptions['wordpressapikey']; ?>'  id='wordpressapikey' size='50' />
<div class='newline1'></div> -->
</td>
</tr>

<tr>
<td class='admintd' width='100%'>
<h4>Listing options</h4>
<div class='newline1'></div>
<div class='adminlabel'>Notify admin when a member posts a new listing or edit an existing one?</div> <input type='checkbox' name='notifyadmin' value='yes' <?php if($notifyadmin=="yes"){ ?> checked="checked" <?php } ?> />
<div class='newline1'></div>
<div class='adminlabel'>Enable admin review before listings go live?</div> <input type='checkbox' name='listingreview' value='yes' <?php if($adminOptions['listingreview']=="yes"){ ?> checked="checked" <?php } ?> />
<div class='newline1'></div>
<div class='adminlabel'>Show contact email on the listing page?</div> <input type='checkbox' name='listingemail' value='yes' <?php if($adminOptions['listingemail']=="yes"){ ?> checked="checked" <?php } ?> />
<div class='newline1'></div>
<div class='adminlabel'>Listing minimum heading length <font size='1'>(characters)</font>:</div> <input type='text' name='headlinelength' value='<?php print $adminOptions['headlinelength']; ?>'  id='headlinelength' size='10' />
<div class='newline1'></div>
<div class='adminlabel'>Listing minimum description length <font size='1'>(characters)</font>:</div> <input type='text' name='descriptionlength' value='<?php print $adminOptions['descriptionlength']; ?>'  id='descriptionlength' size='10' />

</td></tr>

<?php 
if(trim($adminOptions['smtppassword'])!="") $adminOptions['smtppassword']=".......";
?>
<tr>
<td class='admintd' width='100%'>
<h4>Email options <span class='headinginfo'>(all fields under this section are recommended)</span></h4>
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
It is recommended that you use Gmail or Google Apps email and password and leave the authentication type to gmail.<br /><br />

If port 587 doesn’t work with your Gmail/Google apps email then try changing it to 465. If it still doesn't work then your host is probably blocking these ports so contact your hosting support department and ask them to unblock port 465 or 587.<br /><br />

Please make sure that you enter your full email address and not just the username. Also specify your email in 'Contact email' under 'Contact us' page tab at the bottom of this page as otherwise you won't receive any emails, if someone tries to send you an email.
</div>
<div class='newline1'></div>
<div class='adminlabel'>SMTP authentication type:</div>
<select name='smtpauth' id='resmtpAuth' >
<option value='gmail' <?php if($adminOptions['smtpauth']=="gmail") print 'selected="selected"'; ?> >Gmail / Apps</option>
<option value='other' <?php if($adminOptions['smtpauth']=="other") print 'selected="selected"'; ?>>Other server</option>
</select>
<div class='newline1'></div>
<div class='adminlabel'>SMTP server:</div> <input type='text' name='resmtp' id='resmtp' value="<?php print $adminOptions['resmtp']; ?>" size='50' />
<div class='newline1'></div>
<div class='adminlabel'>SMTP Port:</div> <input type='text' name='resmtpport' id='resmtpPort' value="<?php print $adminOptions['resmtpport']; ?>" size='30' />
<div class='newline1'></div>
<div class='adminlabel'><span id='emailusername'>Gmail/Apps email</span>:</div> <input type='text' name='smtpusername' value="<?php print $adminOptions['smtpusername']; ?>" id='smtpusername'  size='30' />
<div class='newline1'></div>
<div class='adminlabel'><span id='emailpassword'>Gmail/Apps password</span>:</div> <input type='password' name='smtppassword' value='<?php print $adminOptions['smtppassword']; ?>' id='smtppassword'  />
<div class='newline1'></div>
<div class='adminlabel'>Enable Debug Mode?</div> <input type='checkbox' name='emaildebug' value='yes' <?php if($adminOptions['emaildebug']=="yes"){ ?> checked="checked" <?php } ?> />
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
    If the email system is not working then you can enable the debug mode and it will print more information on the underlying cause of the problem, when a system tries to send an email. This should only be enabled only for testing purpose as it prints debug information.
</div>
<div class='newline1'></div>
</td>
</tr>

<tr>
<td class='admintd' width='100%'>
<h4>PayPal options <span class='headinginfo'>(if you want to charge people for posting featured listings)</span></h4>
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
<b>Instant Payment Notification (IPN)</b> is PayPal's message service that sends a notification when a transaction is affected. 
In order to accept payments for featured listings, please log in to your PayPal and activate IPN. <br /><br />
Please enter this as your IPN URL: <b><?php $pp_ipn_url = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"])."ipn.php";
  print $pp_ipn_url;
  ?></b>
    </div>
<div class='adminlabel'>PayPal currency:</div>
<select name='ppcurrency' id='ppcurrency' >
<option value='AUD' <?php if($adminOptions['ppcurrency']=="AUD") print " selected='selected' "; ?>>AUD</option>
<option value='BRL' <?php if($adminOptions['ppcurrency']=="BRL") print " selected='selected' "; ?>>BRL</option>
<option value='CAD' <?php if($adminOptions['ppcurrency']=="CAD") print " selected='selected' "; ?>>CAD</option>
<option value='CZK' <?php if($adminOptions['ppcurrency']=="CZK") print " selected='selected' "; ?>>CZK</option>
<option value='DKK' <?php if($adminOptions['ppcurrency']=="DKK") print " selected='selected' "; ?>>DKK</option>
<option value='EUR' <?php if($adminOptions['ppcurrency']=="EUR") print " selected='selected' "; ?>>EUR</option>
<option value='HKD' <?php if($adminOptions['ppcurrency']=="HKD") print " selected='selected' "; ?>>HKD</option>
<option value='HUF' <?php if($adminOptions['ppcurrency']=="HUF") print " selected='selected' "; ?>>HUF</option>
<option value='ILS' <?php if($adminOptions['ppcurrency']=="ILS") print " selected='selected' "; ?>>ILS</option>
<option value='JPY' <?php if($adminOptions['ppcurrency']=="JPY") print " selected='selected' "; ?>>JPY</option>
<option value='MYR' <?php if($adminOptions['ppcurrency']=="MYR") print " selected='selected' "; ?>>MYR</option>
<option value='MXN' <?php if($adminOptions['ppcurrency']=="MXN") print " selected='selected' "; ?>>MXN</option>
<option value='NOK' <?php if($adminOptions['ppcurrency']=="NOK") print " selected='selected' "; ?>>NOK</option>
<option value='NZD' <?php if($adminOptions['ppcurrency']=="NZD") print " selected='selected' "; ?>>NZD</option>
<option value='PHP' <?php if($adminOptions['ppcurrency']=="PHP") print " selected='selected' "; ?>>PHP</option>
<option value='PLN' <?php if($adminOptions['ppcurrency']=="PLN") print " selected='selected' "; ?>>PLN</option>
<option value='GBP' <?php if($adminOptions['ppcurrency']=="GBP") print " selected='selected' "; ?>>GBP</option>
<option value='SGD' <?php if($adminOptions['ppcurrency']=="SGD") print " selected='selected' "; ?>>SGD</option>
<option value='SEK' <?php if($adminOptions['ppcurrency']=="SEK") print " selected='selected' "; ?>>SEK</option>
<option value='CHF' <?php if($adminOptions['ppcurrency']=="CHF") print " selected='selected' "; ?>>CHF</option>
<option value='TWD' <?php if($adminOptions['ppcurrency']=="TWD") print " selected='selected' "; ?>>TWD</option>
<option value='THB' <?php if($adminOptions['ppcurrency']=="THB") print " selected='selected' "; ?>>THB</option>
<option value='TRY' <?php if($adminOptions['ppcurrency']=="TRY") print " selected='selected' "; ?>>TRY</option>
<option value='USD'  <?php if($adminOptions['ppcurrency']=="USD") print " selected='selected' "; ?>>USD</option>
</select>
<div class='newline1'></div>
<div class='adminlabel'>PayPal email:</div> <input type='text' name='ppemail' id='ppemail' value="<?php print $adminOptions['ppemail']; ?>" size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Featured listing duration:</div> <input type='text' name='featuredduration' id='featuredDuration' value="<?php print $adminOptions['featuredduration']; ?>" size='5' onkeyup="if(this.value.match(/[^0-9 ]/g)) { this.value = this.value.replace(/[^0-9 ]/g, '');}" /> days
<div class='newline1'></div>
<div class='adminlabel'>Featured listing price:</div> <input type='text' name='featuredprice' value="<?php print $adminOptions['featuredprice']; ?>" id='featuredPrice'  onkeyup="if(this.value.match(/[^0-9 ]/g)) { this.value = this.value.replace(/[^0-9 ]/g, '');}" size='5' /> <span id='ppdefaultcurrency'></span>
<div class='newline1'></div>
</td>
</tr>

<tr>
<td class='admintd' width='100%'>
<h4>Facebook connect options <span class='headinginfo'>(If you want to allow facebook users to log-in to your site easily.)</span></h4>
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
  In order to use this option, follow these steps:<br />
  1) Log-in to your facebook account and visit <a href='https://developers.facebook.com/apps' target='_blank'>https://developers.facebook.com/apps</a>.<br /><br />
  2) Click on <b>App -> Create a New App</b> button and in <b>Display Name</b> textbox, enter your website title or name. Select <b>App for pages</b> in category dropdown. Click continue and submit the security image check.
<br /><br />
3) Click on <b>Settings</b> and then click on <b>Basic</b>. Click on <b>Add platform</b> and then click on <b>Website</b>.
<br /><br />
4) Under <b>Site URL</b>, copy and paste undermentioned URL:<br />
  <b><u><?php $fb_site_url = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"])."fblogin.php";
  print $fb_site_url;
  ?></u></b><br /><br />

5) Click <b>Save Changes</b> button at the bottom of facebook page.
<br /><br />
6) Click on Status & Review and enable your App by moving the slider at top to 'Yes'.
<br /><br />
7) Click on <b>Dashboard</b> and then <b>Show app secret</b>. Copy and paste <b>App ID</b> and <b>App Secret</b> of the newly created application in the below given boxes respectively.
<br /><br />
8) If you had a failed login attempt with facebook login on your website, then first clear your browser's cookies and cache before testing again.
<br /><br />
    </div>
<div class='newline1'></div>    
<div class='adminlabel'>Facebook App ID:</div> <input type='text' name='fbappid' value='<?php if($isThisDemo=="no") print $adminOptions['fb_app_id']; else print "##########"; ?>'  id='fb_app_id' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Facebook App Secret:</div> <input type='text' name='fbappsecret' value='<?php if($isThisDemo=="no")  print $adminOptions['fb_app_secret']; else print "##########"; ?>' id='fb_app_secret' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Site URL:</div> <input type='text' readonly='readonly' name='fbsiteurl' value='<?php  print $fb_site_url; ?>'  id='fb_site_url'  size='50'  />
<div class='newline1'></div>
</td></tr>

<tr>
<td class='admintd' width='100%'>
<h4>Google Login Settings  <span class='headinginfo'>(If you want to allow viewers to log-in to your site using their Gmail/Google account.)</span></h4>
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
    In order to enable Google login, follow undermentioned steps:<br /><br />
    1) Visit Google Developers Console: <a href='https://console.developers.google.com' target='_blank'>https://console.developers.google.com</a><br /><br />
    2) Click on <strong>Create Project</strong> and specify name of your site as project name.<br /><br />
    3) After a project has been created, click on <strong>APIs & auth</strong> -> <strong>Credentials</strong> in the left menu.<br /><br />
    4) Click on <strong>Create new Client ID</strong> button and select <strong>Web application</strong> as application type.<br /><br />
    5) In <strong>Authorized JavaScript Origins</strong>, enter:<br /> <b><?php print "http://".$_SERVER['SERVER_NAME']; ?></b><br /><br />
    6) And then enter the following URL in the box that says <b> Authorized Redirect URI</b>:<br /> <b><u><?php $g_site_url = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"])."glogin.php";
  print $g_site_url;   ?></u></b><br /><br />
    7) Click on <b>Create Client ID button</b> and then locate <b>Client ID</b> and <b>Client secret</b> under <b>Client ID for web application</b> and paste it in the below given boxes respectively and click on <b>Update options</b> button on this page. <br /><br />
    8) Then go to <strong>APIs & auth</strong> -> <strong>Consent screen</strong> and specify your <strong>email</strong> and <strong>PRODUCT NAME</strong> and click on <strong>Save</strong> button.
    <br /><br />
    </div>
    
<div class='adminlabel'>Enable Google Login?:</div> <input type='checkbox' name='googlelogin' value='1' <?php if($adminOptions['google_login']==1) print " checked='yes' "?> />
<div class='newline1'></div>    
<div class='adminlabel'>Client ID:</div> <input type='text' name='gclientid' value='<?php if($isThisDemo=="no") print $adminOptions['gclientid']; else print "##########"; ?>'  id='gclientid' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Client secret:</div> <input type='text' name='gclientsecret' value='<?php if($isThisDemo=="no")  print $adminOptions['gclientsecret']; else print "##########"; ?>' id='gclientsecret' size='50' />
<div class='newline1'></div>    
    
</td>
</tr>

<tr>
<td class='admintd' width='100%'>
<h4>SEO options <span class='headinginfo'>(title, description and keywords for listing page would be automatically generated)</span></h4>
<div class='newline1'></div>
<div class='adminlabel'>Website title:</div> <input type='text' name='browsertitle' value='<?php print $adminOptions['browsertitle']; ?>'  id='browserTitle' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Tagline:</div> <input type='text' name='tagline' value='<?php print $adminOptions['tagline']; ?>'  id='tagline' size='50' />
<div class='newline1'></div>
<div class='adminlabel'>Homepage description:</div> <textarea name='homepagedescription' cols='40' rows='3'><?php print $adminOptions['homepagedescription']; ?></textarea>
<div class='newline1'></div>
<div class='adminlabel'>Homepage keywords:</div> <textarea name='homepagekeywords' cols='40' rows='3'><?php print $adminOptions['homepagekeywords']; ?></textarea>
<div class='newline1'></div>
</td></tr>

<tr>
<td class='admintd' width='100%'>
<h4>Adsense or other ads <span class='headinginfo'>(paste the ad. code in the below given relevant sections)</span></h4>
<div class='newline1'></div>
<div class='adminlabel'>Top link ad. <font size='1'>(728 x 15)</font>:</div> <textarea name='toplinkad' cols='40' rows='7'><?php print $adminOptions['toplinkad']; ?></textarea>
<div class='newline1'></div>
<div class='adminlabel'>Sidebar ad <font size='1'>(not more than 225px wide)</font>:</div> <textarea name='sidebarad' cols='40' rows='7'><?php print $adminOptions['sidebarad']; ?></textarea>
<div class='newline1'></div>
</td></tr>

<tr>
<td class='admintd' width='100%'>
<h4>API Options <span class='headinginfo'>(You can connect and fetch listings from an external JSON data source)</span></h4>
<div class='newline1'></div>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">x</a>
    <b>1) JSON listings data source:</b> You can connect your external database to this script. In order to do so, you'll need to write a script that reads data from your external database and outputs data in JSON format. You can refer to a test file <b>jsonDataTest.php</b> which can serve as an example for this. The required JSON format is:<br /><br />
    {[{"la":"43.589","lo":"-79.6441"},{"la":"43.6915","lo":"-79.5091"},.....]}<br /><br />
    Here <b>la</b> is latitude and <b>lo</b> is the longitude of a listing. <br /><br />
    <b>2) JSON URL for text results on map:</b> This is the url of the page which should return text results in map mode. You can refer to $allTextListings in function getTextDataJson of functions.inc.php to view the correct format of data that will be returned.<br /><br /> 
    <textarea id='sampledata2' name='sampledata2' cols='80' rows='7' readonly> 
<div id="textrecord-17" class="textrecord">
<div class="textimage"><img width="80" src="images/no-image.png"></div>
<div class="textcontent">Content goes here for listing #17</div>
<span class="textlatlong" style="display:none;">25.1448,83.1347</span>
</div>

<div id="textrecord-15" class="textrecord">
<div class="textimage"><img width="80" src="images/no-image.png"></div>
<div class="textcontent">Content goes here for listing #15</div>
<span class="textlatlong" style="display:none;">25.1241,83.1154</span>
</div>
</textarea>
<br />
Here 17 is the listing id so div id is textrecord-17 and 25.1448,83.1347 are the latitude & longitude of the listing, separated by a coma.
  <br /><br />  
    <b>3) JSON marker data:</b> This is the url of the page which should return marker data. Please refer to the API documentation for more information.<br /><br />
    <b>4) JSON full listing data URL:</b> This is the url of the page which should return data for a particular listing identified by <b>id</b>.
</div>
<div class='adminlabel'>JSON listings data source URL:</div> <input type='text' name='jsonurl' value='<?php  print $adminOptions['jsonurl']; ?>'  id='jsonurl' class='col-md-6 col-lg-6' />
<div class='newline1'></div>
<div class='adminlabel'>JSON URL for text results on map:</div> <input type='text' name='jsontexturl' value='<?php  print $adminOptions['jsontexturl']; ?>'  id='jsontexturl' class='col-md-6 col-lg-6' />
<div class='newline1'></div>
<div class='adminlabel'>JSON marker data URL:</div> <input type='text' name='markerjsonurl' value='<?php  print $adminOptions['markerjsonurl']; ?>'  id='markerjsonurl' class='col-md-6 col-lg-6' />
<div class='newline1'></div>
<div class='adminlabel'>JSON full listing data URL:</div> <input type='text' name='listingjsonurl' value='<?php  print $adminOptions['listingjsonurl']; ?>'  id='listingjsonurl' class='col-md-6 col-lg-6' />
<div class='newline1'></div>
</td></tr>

<tr>
<td class='admintd' width='100%'>
<h4>'Contact us' page</h4>
<div class='newline1'></div>
<div class='adminlabel'>Contact address. <font size='1'>(displayed on contact us)</font>:</div> <textarea id='contactaddress' name='contactaddress' cols='40' rows='7'><?php print $adminOptions['contactaddress']; ?></textarea>
<div class='newline1'></div>
<div class='adminlabel'>Contact email <font size='1'>(for contact form)</font>:</div> <input type='text' name='contactformemail' value='<?php print $adminOptions['contactformemail']; ?>'  id='contactformemail' size='50' />
<div class='newline1'></div>
<input type='hidden'  name='ptype' value='UpdateAdminOptions'>
<p align='right'><input type='submit'  class='rebutton btn btn-primary btn-large' id='updateAdminOptionsButton' value='Update Options'></p>
</td></tr>

</table>
</form>
</div>
<?php } ?>