<?php 
$dbo=PDBO;
$dbtable="{$dbo}.`00_contacts`";


?>


<h5>
	Registration SY <span class="u" ><?php echo $dbyr; ?></span>
	| <?php $this->shovel('homelinks'); ?>
	

</h5>


<?php 

	$this->shovel('filter_redirect'); 
		
?>	


<?php if($scid): ?>
<?php 
	pr($row);
?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
	<tr><th>SCID</th><td class="vc200" ><?php echo $row['scid']; ?></td></tr>
	<tr><th>ID Number</th><td><?php echo $row['studcode']; ?></td></tr>
	<tr><th>Name</th><td><?php echo $row['student']; ?></td></tr>
	<tr><th>Level</th>
		<td><select class="vc200" name="post[level_id]" >
			<?php foreach($unilevels AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select></td>
	</tr>		
	<tr><th>Classroom</th>
		<td><select class="vc200" name="post[crid]" >
			<?php foreach($uniclassrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select></td>
	</tr>

	<tr><th>Graduating</th>
		<td><select class="vc200" name="post[is_graduating]" >
			<option value="1" >Yes</option>
		</select></td>
	</tr>	
	
	
	<tr><th colspan=2><input type="submit" name="submit" value="Submit" /></th></tr>
</table>
</form>
<?php endif; ?>






<script>
var gurl = "http://<?php echo GURL; ?>";
var dbtable = "<?php echo $dbtable; ?>";
var limits = 20;

		
$(function(){
	// hd();	
	$('#hdpdiv').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});
	
	
})





function axnFilter(id){	
	var url = gurl+'/college/register/'+id;	
	window.location = url;			
}	/* fxn */



</script>



<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>









