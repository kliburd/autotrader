var xmlhttp;
var styleid;

function infoResults(str,type,divLoc)
{
styleid=divLoc;
//str=escape(str);
//alert(str);
if (str.length==0)
  {
  document.getElementById(styleid).innerHTML="";
  document.getElementById(styleid).style.border="0px";
  return;
  }

xmlhttp=GetXmlHttpObject()
if (xmlhttp==null)
  {
  alert ("Your browser does not support XML HTTP Request");
  return;
  }
//alert(imgStr);
if(type==5 || type==8 || type==14){
//document.getElementById(styleid).innerHTML=imgStr2;
$('#'+styleid).html(imgStr2);
}else{
//document.getElementById(styleid).innerHTML=imgStr;
$('#'+styleid).html(imgStr);
}

//document.getElementById(styleid).style.border="0px";

var url="infoResults.php";
url=url+"?q="+str+"&type="+type;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged ;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

}

function stateChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById(styleid).innerHTML=xmlhttp.responseText;
  //document.getElementById(styleid).style.border="1px solid #A5ACB2";
  
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
