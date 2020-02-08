<?php include("config.php"); include_once("functions.inc.php"); ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);
$rssqr="select * from $reListingTable order by id desc";
$rssresult=mysqli_query($coni,$rssqr);
?>
<?php while($rss=mysqli_fetch_assoc($rssresult)) {
     if(($_SESSION["autoadmin_settings"]["refriendlyurl"]=="enabled")|| ($refriendlyurl=="enabled")){
$relistingLink=$full_url_path.friendlyUrl($rss['category'],"_")."/".friendlyUrl($rss['subcategory'],"_")."/"."id-".$rss['id']."-".$region_slug."-".friendlyUrl($rss['headline']);
      }else $relistingLink=$full_url_path."index.php?ptype=viewFullListing&amp;reid=".$rss['id'];
	list($lastmod,$temptime)=explode(" ",$rss['dttm_modified']);
?>
<url>
	<loc><?php print $relistingLink; ?></loc>
	<lastmod><?php print $lastmod; ?></lastmod>
</url>

<?php }
    $qrpg="select id, page_name from $pageTable order by page_order asc;";
    $resultpg=mysqli_query($coni,$qrpg);
    while($apage=mysqli_fetch_assoc($resultpg)){
    $customPageLink=$full_url_path."index.php?ptype=page&amp;id=".$apage['id'];
    ?>
    <url>
	<loc><?php print $customPageLink; ?></loc>
	<priority>0.5</priority>
	</url>
    <?php 
    }

    $contactLink=$full_url_path."index.php?ptype=contactus"; ?>
<url>
	<loc><?php print $contactLink; ?></loc>
	<priority>0.5</priority>
</url>

</urlset>