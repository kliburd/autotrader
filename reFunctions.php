function confirmListingdelete(reid,deltype){
<?php if($isThisDemo!="yes"){ ?>
    var agree=confirm("<?php print $relanguage_tags["Please confirm that you wish to delete listing"];?> #"+reid+"?");
    //alert("Deleting a listing function has been disabled in demo.");
   // return false;
	childid='child-row'+reid;
	parentid='parent-row'+reid;
	fulldivid="rememberAction";

	 if (agree){
		 if(deltype==1){
			 infoResults(reid,11,parentid);
			 $('#'+childid).css('display', 'none');
			 $('#'+parentid).css('display', 'none');
		 }
		 if(deltype==2){
			 infoResults(reid,11,fulldivid);
			 $('#'+fulldivid).css('display', 'none');
			 $('#'+childid).css('display', 'none');
			 $('#'+parentid).css('display', 'none');
		 }
		 
		 
	}
<?php }else{ ?>
alert("Listing can't be deleted in demo");
return false;
<?php } ?>	

}

function echeck(str) {

	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("<?php print $relanguage_tags["Invalid E-mail ID"];?>")
	   return false
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("<?php print $relanguage_tags["Invalid E-mail ID"];?>")
	   return false
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
	    alert("<?php print $relanguage_tags["Invalid E-mail ID"];?>")
	    return false
	}

	 if (str.indexOf(at,(lat+1))!=-1){
	    alert("<?php print $relanguage_tags["Invalid E-mail ID"];?>")
	    return false
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
	    alert("<?php print $relanguage_tags["Invalid E-mail ID"];?>")
	    return false
	 }

	 if (str.indexOf(dot,(lat+2))==-1){
	    alert("<?php print $relanguage_tags["Invalid E-mail ID"];?>")
	    return false
	 }
	
	 if (str.indexOf(" ")!=-1){
	    alert("<?php print $relanguage_tags["Invalid E-mail ID"];?>")
	    return false
	 }

		 return true					
}

function processForgotPassForm(){
	var emailID=document.forgotPasswordForm.reemail;
	if (echeck(emailID.value)==false){
		emailID.value=""
		emailID.focus()
		return false
	}
	if ((emailID.value==null)||(emailID.value=="")){
		alert("<?php print $relanguage_tags["Please enter your"]." ".$relanguage_tags["Email"];?> ID")
		emailID.focus()
		return false;
	}else{
		infoResults(emailID.value,10,'sidebarLogin');
	}
}

function validateRegForm(){
	var reusername=$("input#reusername").val();
	var emailID=document.registerForm.reemail;
	
	if ((reusername==null)||(reusername.length<4)){
		alert("<?php print $relanguage_tags["Please enter your"]." ".$relanguage_tags["Username"];?> (<?php print $relanguage_tags["at least"]." 4 ".$relanguage_tags["characters"];?>).");
		return false;
	}
	
	if ((emailID.value==null)||(emailID.value=="")){
			alert("<?php print $relanguage_tags["Please enter your"]." ".$relanguage_tags["Email"];?> ID");
			emailID.focus();
			return false;
		}
		if (echeck(emailID.value)==false){
			emailID.value="";
			emailID.focus();
			return false;
		}
		
		
		var passVal=$("input#repassword").val();
		var cpassVal=$("input#recpassword").val();
		var captcha_code=$("input#captcha_code").val();
		
		if(passVal.length>=6){ 
		    if(passVal==cpassVal){ 
		    	var allData=reusername+":::"+emailID.value+":::"+passVal+":::"+captcha_code;
		       	infoResults(allData,3,'sidebarLogin'); 
		    }else{
		    	alert("<?php print $relanguage_tags["Passwords don't match"]." ".$relanguage_tags["Please enter same password twice"];?>. .");
		    	return false;
		    }
		}else{ 
			alert("<?php print $relanguage_tags["Please make sure that password is of at least 6 digits"]; ?>."); 
			return false;	
		}
		
		return true;
		
}

