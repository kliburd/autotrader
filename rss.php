<?php
include("config.php");

$languageCodes = array(
 "aa" => "Afar",
 "ab" => "Abkhazian",
 "ae" => "Avestan",
 "af" => "Afrikaans",
 "ak" => "Akan",
 "am" => "Amharic",
 "an" => "Aragonese",
 "ar" => "Arabic",
 "as" => "Assamese",
 "av" => "Avaric",
 "ay" => "Aymara",
 "az" => "Azerbaijani",
 "ba" => "Bashkir",
 "be" => "Belarusian",
 "bg" => "Bulgarian",
 "bh" => "Bihari",
 "bi" => "Bislama",
 "bm" => "Bambara",
 "bn" => "Bengali",
 "bo" => "Tibetan",
 "br" => "Breton",
 "bs" => "Bosnian",
 "ca" => "Catalan",
 "ce" => "Chechen",
 "ch" => "Chamorro",
 "co" => "Corsican",
 "cr" => "Cree",
 "cs" => "Czech",
 "cu" => "Church Slavic",
 "cv" => "Chuvash",
 "cy" => "Welsh",
 "da" => "Danish",
 "de" => "German",
 "dv" => "Divehi",
 "dz" => "Dzongkha",
 "ee" => "Ewe",
 "el" => "Greek",
 "en" => "English",
 "eo" => "Esperanto",
 "es" => "Spanish",
 "et" => "Estonian",
 "eu" => "Basque",
 "fa" => "Persian",
 "ff" => "Fulah",
 "fi" => "Finnish",
 "fj" => "Fijian",
 "fo" => "Faroese",
 "fr" => "French",
 "fy" => "Western Frisian",
 "ga" => "Irish",
 "gd" => "Scottish Gaelic",
 "gl" => "Galician",
 "gn" => "Guarani",
 "gu" => "Gujarati",
 "gv" => "Manx",
 "ha" => "Hausa",
 "he" => "Hebrew",
 "hi" => "Hindi",
 "ho" => "Hiri Motu",
 "hr" => "Croatian",
 "ht" => "Haitian",
 "hu" => "Hungarian",
 "hy" => "Armenian",
 "hz" => "Herero",
 "ia" => "Interlingua (International Auxiliary Language Association)",
 "id" => "Indonesian",
 "ie" => "Interlingue",
 "ig" => "Igbo",
 "ii" => "Sichuan Yi",
 "ik" => "Inupiaq",
 "io" => "Ido",
 "is" => "Icelandic",
 "it" => "Italian",
 "iu" => "Inuktitut",
 "ja" => "Japanese",
 "jv" => "Javanese",
 "ka" => "Georgian",
 "kg" => "Kongo",
 "ki" => "Kikuyu",
 "kj" => "Kwanyama",
 "kk" => "Kazakh",
 "kl" => "Kalaallisut",
 "km" => "Khmer",
 "kn" => "Kannada",
 "ko" => "Korean",
 "kr" => "Kanuri",
 "ks" => "Kashmiri",
 "ku" => "Kurdish",
 "kv" => "Komi",
 "kw" => "Cornish",
 "ky" => "Kirghiz",
 "la" => "Latin",
 "lb" => "Luxembourgish",
 "lg" => "Ganda",
 "li" => "Limburgish",
 "ln" => "Lingala",
 "lo" => "Lao",
 "lt" => "Lithuanian",
 "lu" => "Luba-Katanga",
 "lv" => "Latvian",
 "mg" => "Malagasy",
 "mh" => "Marshallese",
 "mi" => "Maori",
 "mk" => "Macedonian",
 "ml" => "Malayalam",
 "mn" => "Mongolian",
 "mr" => "Marathi",
 "ms" => "Malay",
 "mt" => "Maltese",
 "my" => "Burmese",
 "na" => "Nauru",
 "nb" => "Norwegian Bokmal",
 "nd" => "North Ndebele",
 "ne" => "Nepali",
 "ng" => "Ndonga",
 "nl" => "Dutch",
 "nn" => "Norwegian Nynorsk",
 "no" => "Norwegian",
 "nr" => "South Ndebele",
 "nv" => "Navajo",
 "ny" => "Chichewa",
 "oc" => "Occitan",
 "oj" => "Ojibwa",
 "om" => "Oromo",
 "or" => "Oriya",
 "os" => "Ossetian",
 "pa" => "Panjabi",
 "pi" => "Pali",
 "pl" => "Polish",
 "ps" => "Pashto",
 "pt" => "Portuguese",
 "qu" => "Quechua",
 "rm" => "Raeto-Romance",
 "rn" => "Kirundi",
 "ro" => "Romanian",
 "ru" => "Russian",
 "rw" => "Kinyarwanda",
 "sa" => "Sanskrit",
 "sc" => "Sardinian",
 "sd" => "Sindhi",
 "se" => "Northern Sami",
 "sg" => "Sango",
 "si" => "Sinhala",
 "sk" => "Slovak",
 "sl" => "Slovenian",
 "sm" => "Samoan",
 "sn" => "Shona",
 "so" => "Somali",
 "sq" => "Albanian",
 "sr" => "Serbian",
 "ss" => "Swati",
 "st" => "Southern Sotho",
 "su" => "Sundanese",
 "sv" => "Swedish",
 "sw" => "Swahili",
 "ta" => "Tamil",
 "te" => "Telugu",
 "tg" => "Tajik",
 "th" => "Thai",
 "ti" => "Tigrinya",
 "tk" => "Turkmen",
 "tl" => "Tagalog",
 "tn" => "Tswana",
 "to" => "Tonga",
 "tr" => "Turkish",
 "ts" => "Tsonga",
 "tt" => "Tatar",
 "tw" => "Twi",
 "ty" => "Tahitian",
 "ug" => "Uighur",
 "uk" => "Ukrainian",
 "ur" => "Urdu",
 "uz" => "Uzbek",
 "ve" => "Venda",
 "vi" => "Vietnamese",
 "vo" => "Volapuk",
 "wa" => "Walloon",
 "wo" => "Wolof",
 "xh" => "Xhosa",
 "yi" => "Yiddish",
 "yo" => "Yoruba",
 "za" => "Zhuang",
 "zh" => "Chinese",
 "zu" => "Zulu"
);

$lang_code = array_search($adminOptions['defaultlanguage'], $languageCodes);

print "<?xml version='1.0' encoding='UTF-8'?>";
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$numpages=htmlspecialchars($_GET['num'], ENT_QUOTES, 'UTF-8');
if($numpages!="" && $numpages > 0){
	$limitClause=" limit 0, ".$numpages;
}else{
	$limitClause=" limit 0, 10";
}
$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);

$qr1="select * from $adminOptionTable";
$result1=mysqli_query($coni,$qr1);
$adminOptions=mysqli_fetch_assoc($result1);

$rssqr="select * from $reListingTable order by id desc $limitClause";
$rssresult=mysqli_query($coni,$rssqr);

?>
<rss version='2.0'>
<channel>

<title><?php print str_replace('&','&amp;',$adminOptions['browsertitle']); ?></title>
<link><?php print $full_url_path; ?></link>
<description><![CDATA[<?php print strip_tags(str_replace('&','&amp;',$adminOptions['homepagedescription'])); ?>]]></description>
<language><?php print $lang_code; ?></language>

<?php 
while($rss=mysqli_fetch_assoc($rssresult)){
   if($_SESSION["autoadmin_settings"]["refriendlyurl"]=="enabled"){
    $headline_slug=friendlyUrl($rss['headline']); 
$relistingLink=$full_url_path.friendlyUrl($rss['category'],"_")."/".friendlyUrl($rss['subcategory'],"_")."/"."id-".$rss['id']."-".$region."-".$headline_slug;
   }else $relistingLink=$full_url_path."index.php?ptype=viewFullListing&amp;reid=".$rss['id'];
	$smallDesc=utf8_substr(strip_tags(str_replace('&','&amp;',$rss['description'])),0,250)."....";
?>
<item>
<title><![CDATA[<?php print strip_tags(str_replace('&','&amp;',$rss['headline'])); ?>]]></title>
<link><?php print $relistingLink; ?></link>
<description><![CDATA[<?php print $smallDesc; ?>]]></description>
</item>
<?php  } ?>
</channel>
</rss>

<?php 
function friendlyUrl($str = '',$replace='-') {

    $friendlyURL = htmlentities($str, ENT_COMPAT, "UTF-8", false); 
    $friendlyURL = preg_replace('/&([a-z]{1,2})(?:acute|lig|grave|ring|tilde|uml|cedil|caron);/i','\1',$friendlyURL);
    $friendlyURL = html_entity_decode($friendlyURL,ENT_COMPAT, "UTF-8"); 
    $friendlyURL = preg_replace('/[^a-z0-9-]+/i', $replace, $friendlyURL);
    $friendlyURL = preg_replace('/-+/', $replace, $friendlyURL);
    $friendlyURL = trim($friendlyURL, $replace);
    $friendlyURL = strtolower($friendlyURL);
    return $friendlyURL;

}
function utf8_substr($str,$start)
{	preg_match_all("/./u", $str, $ar);
	if(func_num_args() >= 3) {
		$end = func_get_arg(2);
		return join("",array_slice($ar[0],$start,$end));
	} else {
		return join("",array_slice($ar[0],$start));
	}
}
?>