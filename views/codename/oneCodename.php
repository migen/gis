<?php


?>

<h5>

	Account | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'photos/one/'.$id; ?>">Photo</a> 
	| <a href="<?php echo URL.'codename/name/'.$id; ?>">Name</a> 
	| <a href="<?php echo URL.'codename/student/'.$id; ?>">SCN</a> 
	| <a href="<?php echo URL.'contacts/ucis/'.$id; ?>">UCIS</a> 
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'mgt/pass/'.$id; ?>">Pass</a> 	
	<?php endif; ?>
	
</h5>

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>

<?php if($id): ?>
<form method="POST" >
<table class="gis-table-bordered table-fx" >
	<tr><th>UCID </th><td>
		<?php echo $row['id']; ?>
		: <span class="b" >PCID</span> <input class="" name="post[parent_id]"
				value="<?php echo $row['parent_id']; ?>" >		
	</td></tr>	
	<tr><th>Account (Login)</th><td><input class="vc300" name="post[account]"
		value="<?php echo $row['account']; ?>" ></td></tr>			
	<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
	<tr><td colspan=2><input type="submit" name="submit" value="Save" ></td></tr>
		
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
	var url = gurl+'/codename/one/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

