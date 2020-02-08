<?php if($memtype==9){ ?>
<div id='perimeter'>
<fieldset id='reProfilePage'>
<legend>
<b><?php print __("Features"); ?></b>
</legend>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert" href="#">x</a>
    <h4 class="alert-heading">Help</h4>
    You can add/delete features on this page. These features would be shown on <b>add/edit listing</b> page so members can select them while adding/editing a listing. 
    Always add a feature name in English and then add its language translation on language tags page, if your site's default language is not English. <a target='_blank' href='http://www.codiator.com/Auto-Trading-Made-Easy/Help/Features.html'>More help here</a>.
  </div>

<form name='updatefeatures' />
<table width='100%' align='center'>
<tr><td align='center'>
<b>Add Feature (in English)</b><br /><br />
<input type='text' name='featurename' id='featurename' size='35' /><br />
<input type='button' class='btn btn-large' id='addfeature' value='Add a feature' />
</td></tr>
<tr><td align='center'>
<div id='allfeatures'></div>
</td></tr>
</table>
</form>

</fieldset>
</div>
<?php  } ?>