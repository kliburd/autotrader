<?php if($memtype==9){ ?>
<div id='perimeter'>
<fieldset id='reProfilePage'>
<legend>
<b>Update <?php print __("Brands"); ?></b>
</legend>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert" href="#">x</a>
    <h4 class="alert-heading">Help</h4>
    You can add/delete <?php print __("Brands"); ?> and their models on this page. Always add a <?php print __("brands"); ?> or a <?php print __("model"); ?> name in English and then <strong>update</strong> its language translation on language tags page (near the bottom), if you site's default language is not English. <a target='_blank' href='http://www.codiator.com/Auto-Trading-Made-Easy/Help/Brands.html'>More help here</a>.
  </div>

<form name='updatecategories' />
<table width='100%' align='center'>
<tr><td align='center'>
<b>Add Brand (in English)</b><br /><br />
<input type='text' name='catname' id='catname' size='35' /><br /><br />
<input type='hidden' name='catprice' id='catprice' value='true' />
<br />
<input type='button' id='addcat'  class='btn btn-large' value='Add Brand' />
</td></tr>
<tr><td align='center'>
<div id='allcats'></div>
</td></tr>
</table>
</form>

</fieldset>
</div>
<?php  } ?>