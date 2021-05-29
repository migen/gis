<?php


?>

<h5>
	Name | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'codename/one/'.$id; ?>">Account</a> 
	| <a href="<?php echo URL.'photos/one/'.$id; ?>">Photo</a> 
	| <a href="<?php echo URL.'contacts/ucis/'.$id; ?>">UCIS</a> 
	| <a href="<?php echo URL.'codename/student/'.$id; ?>">SCN</a> 
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

	
	<tr><th>Code (ID No)</th><td><input class="vc300" name="post[code]"
		value="<?php echo $row['code']; ?>" ></td></tr>			
	<tr><th>Account (Login)</th>
	<td><?php echo $row['account']; ?></td></tr>			
	<tr><th>Name</th><td><input class="vc300" name="post[name]"
		value="<?php echo $row['name']; ?>" ></td></tr>
	<tr><th>Sex (1-Male,0-Female)</th><td><input class="vc300" name="post[is_male]"
		value="<?php echo $row['is_male']; ?>" ></td></tr>		
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
	var url = gurl+'/codename/name/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

