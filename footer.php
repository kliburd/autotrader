<?php

print call_plugin("sitefooter",sitefooter($reSiteFooter));

function sitefooter($reSiteFooter){
ob_start();  
    ?>
<div class='container'>
    <div class='pull-right'><div style='padding:0 10px;'><?php print $reSiteFooter; ?></div>
        <nav class="footer-nav">
            <ul>
                <?php
                include("site.inc.php");
                $con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
    mysqli_select_db($coni,$database);
                $qrpg="select id, page_name, topmenu, footermenu from pages order by page_order asc;";
    $resultpg=mysqli_query($coni,$qrpg);
    while($apage=mysqli_fetch_assoc($resultpg)){
           if($refriendlyurl=="enabled"){
            $pageLink=friendlyUrl($apage['page_name'],"_")."-".$apage['id'];
           }else{
            $pageLink="index.php?ptype=page&amp;id=".$apage['id'];
           }
           if($apage['footermenu']==1){
            print '<li><a href="'.$pageLink.'">'.$apage['page_name'].'</a></li>';
           } 
           }?>
           <li><a href='<?php print $contactPageLink; ?>'><?php print __("Contact us");?></a></li>
           </ul>
        </nav>
        
    </div>
</div><!-- end #footer -->
 
</body>
</html>
<?php 
return ob_get_clean();
} ?>