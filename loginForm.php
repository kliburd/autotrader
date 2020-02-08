<div id='sidebarLogin'>
<?php if(!isset($_SESSION["myusername"])){ 
if($ptype!="checklogin"){ ?>
<form id="form1" class="loginForm"  method="post" action="index.php">
<div class="form-group" style="text-align:center;">
 <label class="control-label" for="reusername"><b><?php print $relanguage_tags["Username"];?>:</b></label>
 <div class="controls"><input id="reusername"  name="myusername" size='20' style='width:162px;' type="text" maxlength="255" value="<?php if($isThisDemo=="yes") print "admin"; ?>"/> </div>
</div>
 
<div class="form-group" style="text-align:center;">
<label class="control-label" for="repassword"><b><?php print $relanguage_tags["Password"];?>:</b></label>
<div class="controls"><input id="repassword"  name="mypassword" size='20' style='width:162px;' type='password' maxlength="255" value="<?php if($isThisDemo=="yes") print "testtest"; ?>"/> </div>
</div>

<div class="form-group" style="text-align:center;">
<div class="controls">
<input type='hidden' name='ptype' value='checklogin' />
<input type='hidden' name="requerystring" value="<?php print htmlspecialchars($_SERVER['QUERY_STRING']); ?>" />
  <div style="margin-top: 18px;">
   <div class="btn-group">
    <button id="loginButton" type="submit" name="submit"  class='btn btn-sm'><?php print $relanguage_tags["Login"];?></button>
   </div>
    
    <div class="btn-group">
    <button  id="registerButton" type="button"  class='btn btn-sm'  name="register" ><?php print $relanguage_tags["Register"];?></button>
   </div>
    
     <?php if($fb_app_id!="" && $fb_app_secret!=""){ ?><br /><br /><br />
    <a href='fblogin.php' style="padding:0;" target="_top"><img style="border:0;" src='images/facebook_login.png' alt='Facebook login' /></a>
    <?php } ?>
    <?php if($google_login && $gclientid!="" && $gclientsecret!=""){ ?><br /><br />
    <a href='glogin.php' target="_top" style="padding:0;"><img style="border:0;" src='images/google_login.png' alt='Google login' /></a>
    <?php } if($yahoo_login){ ?><br /><br />
    <a href='ylogin.php' target="_top" style="padding:0;"><img style="border:0;" src='images/yahoo_login.png' alt='Yahoo login' /></a>
    <?php } ?>
    <br />
   </div>
</div>
</div>

<br />
<p><span class='small'><a href='javascript: void(0)' id='forgotPasswordLink'><?php print $relanguage_tags["Forgot password"];?>?</a>
<?php if($isThisDemo=="yes"){ ?>
<br /><br /><b>Username:</b> admin<br /><b>Password:</b> testtest
<?php } ?>
</span>
</p>
</form> <br />

<?php } 
}else{ ?>
<div id='memberMenu'>
<div <?php if($ptype=="" || $ptype=="home") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=home'><?php print $relanguage_tags["Home"];?></a></div>
<div <?php if($memtype==9) { if($ptype=="adminOptions"  || $ptype=="UpdateAdminOptions") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=adminOptions'><?php print $relanguage_tags["Admin Options"];?></a></div> <?php } ?>
<div <?php if($memtype==9) { if($ptype=="allMembers") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=allMembers'><?php print $relanguage_tags["Members"];?></a></div> <?php } ?>
<div  <?php if($ptype=="submitReListing" || $ptype=="addReListing") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=submitReListing'><?php print $relanguage_tags["Add Listing"];?></a></div>
<?php if(isset($_SESSION['memtype']) && $_SESSION['memtype']==9){ ?>
<div <?php if($ptype=="" || $ptype=="home") print "class='memberMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=home'><?php print __("Review Listings");?></a></div>
<?php } ?>
<div  <?php if($ptype=="viewMemberListing") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=viewMemberListing'><?php print $relanguage_tags["My listings"];?></a></div>
<div  <?php if($ptype=="myprofile") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=myprofile'><?php print $relanguage_tags["My Profile"];?></a></div>
<div  <?php if($memtype==9) { if($ptype=="addeditpage") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=addeditpage'><?php print __("Pages"); } ?></a></div>
<div  <?php if($memtype==9) { if($ptype=="categories") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=categories'><?php print $relanguage_tags["Brand"]; } ?></a></div>
<div  <?php if($memtype==9) { if($ptype=="features") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=features'><?php print $relanguage_tags["Features"]; } ?></a></div>
<div  <?php if($memtype==9) { if($ptype=="bodytype") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=bodytype'><?php print $relanguage_tags["Body Type"]; } ?></a></div>
<div  <?php if($memtype==9) { if($ptype=="fueltype") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=fueltype'><?php print $relanguage_tags["Fuel Type"]; } ?></a></div>

<div  <?php if($memtype==9) { if($ptype=="pricerange") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=pricerange'><?php print $relanguage_tags["Price Range"]; } ?></a></div>
<div  <?php if($memtype==9) { if($ptype=="languagetags" || $ptype=="updateLanguageTags") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?ptype=languagetags'><?php print $relanguage_tags["Language tags"]; } ?></a></div>
<div  <?php if($memtype==9) { if($ptype=="faq") print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='http://codecanyon.net/item/auto-trading-made-easy/1897428/support' target='_blank'><?php print __("FAQs"); } ?></a></div>
<?php foreach($_SESSION["bmenu"] as $mkey=>$mvalue){  
    if($mvalue[1]==9){
    if($memtype==9){    ?>
<div  <?php if($ptype==$mvalue[0]) print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?cpage=1&ptype=<?php print $mvalue[0]; ?>'><?php print __($mkey); ?></a></div>    
<?php 
    }
    }else{
        ?>
<div  <?php if($ptype==$mvalue[0]) print "class='currentMenuItem'"; else print "class='memberMenuItem'"; ?> ><a href='index.php?cpage=1&ptype=<?php print $mvalue[0]; ?>'><?php print __($mkey); ?></a></div>           
        <?php
    }
} ?>        
<div class='memberMenuItem'><a href='logout.php'><?php print $relanguage_tags["Logout"];?></a></div>
</div>
<?php } ?>
</div>