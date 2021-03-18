<h5>
	Codes Edit
	| <?php $this->shovel('homelinks'); ?>

</h5>


<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>UCID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>PCID</th><td><input name="post[parent_id]" value="<?php echo $row['pcid']; ?>" /></td></tr>
<tr><th>Name</th><td><input class="vc300" name="post[name]" value="<?php echo $row['name']; ?>" /></td></tr>
<tr><th>Code (ID)</th><td><input name="post[code]" value="<?php echo $row['code']; ?>" /></td></tr>
<tr><th>Account (Login)</th><td><input name="post[account]" value="<?php echo $row['account']; ?>" /></td></tr>
<tr><th>Role ID</th><td><input name="post[role_id]" value="<?php echo $row['role_id']; ?>" /></td></tr>
<tr><th>Is Active</th><td><input name="post[is_active]" value="<?php echo $row['is_active']; ?>" /></td></tr>

<tr><td colspan=2 >
	<input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');" />
	<button><a class="no-underline txt-black" href="<?php echo URL.'purge/user/'.$row['id']; ?>" 
		onclick="return confirm('Dangerous! Sure?');" >Purge</a></button>
</td></tr>

</table>
</form>



<script>
var gurl = "http://<?php echo GURL; ?>";
// var sy = "<?php echo DBYR; ?>";
var limits='20';


$(function(){ $('#names').hide(); })

function redirContact(ucid){
	var url = gurl+'/codes/edit/'+ucid;	
	window.location = url;		
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
