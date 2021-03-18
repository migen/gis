<?php 



?>

<form method="GET" >
<p>
<table class="screen gis-table-bordered" >
<tr>
	<td><input type="submit" name="submit" value="Filter"  /></td>	
	<th>SY</th>
	<th><input id="sy" class="pdl05 vc70" type="number" name="sy"  value="<?php echo $sy; ?>" /></th>
	<th>Terminal</th>
	<td><input class="vc50 center" type="number" name="terminal" id="terminal"
		value="<?php echo (isset($_GET['terminal']))? $_GET['terminal']:$t; ?>" <?php echo ($admin)? NULL:'readonly'; ?> /></td>
	<th>Ecid</th>
	<td><input class="vc70 center" id="ecid" name="ecid"
		value="<?php echo (isset($_GET['ecid']))? $_GET['ecid']:$_SESSION['ucid']; ?>" /></td>		
	<th>Start</th>
	<td><input class="pdl05" type="date" id="start" name="start"
		value="<?php echo (isset($_GET['start']))? $_GET['start']:$today; ?>" /></td>
	<th>End</th>
	<td><input class="pdl05" type="date" id="end" name="end"
		value="<?php echo (isset($_GET['end']))? $_GET['end']:$today; ?>" /></td>	
	<th>Size</th>
	<td><input class="pdl05 vc30" type="text" id="fontsize" name="fontsize"
		value="<?php echo (isset($_GET['fontsize']))? $_GET['fontsize']:'1.2'; ?>" /></td>			

</tr>		

<?php if($admin): ?>		
<tr>
	<td colspan="13" >
		<select class="vc200" onchange="xgetEcid(this.value);" >
		<option>Choose</option>			
		<option value="0" >All Employees</option>			
		<?php foreach($cashiers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
				<?php echo (isset($_GET['ecid']) && ($_GET['ecid']==$sel['id']))? 'selected':NULL; ?>
			><?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select></td>		
</tr>

<?php endif; ?>	

</tr>
</table>
</p>
</form>

<?php if($admin): ?>
<p>*Note - Set value=0 to exclude that condition, example ecid=0 to get combined sales of employees of a specific terminal.</p>
<?php endif; ?>



<!-------------------------------------------------------------->
<script>
var gurl = 'http://<?php echo GURL; ?>';

$(function(){

})



function xgetEcid(ecid){
	$('#ecid').val(ecid);
}


</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>