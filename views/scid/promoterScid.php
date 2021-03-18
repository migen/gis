<?php


?>

<h5>
	Promoter | <?php $this->shovel('homelinks'); ?>
	
</h5>

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>

<?php if($id): ?>
<form method="POST" >
<table class="gis-table-bordered table-fx" >
	<tr><th>ID</th><td><?php echo $row['ucid']; ?></td></tr>
	<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
	
	<tr><th>Is Promoted </th><td><input class="vc50" name="post[is_promoted]"
		value="<?php echo $row['is_promoted']; ?>" type="number" min=0 max=1 ></td></tr>		
	<tr><th colspan="2" ><input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');"  /></th></tr>		
</table>
</form>
<?php endif; ?>

<div id="names" >names</div>


<script>
var gurl = 'http://<?php echo GURL; ?>';
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

})



function redirContact(ucid){
	var url = gurl+'/scid/promoter/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

