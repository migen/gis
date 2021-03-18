<?php 
pr($_SESSION['q']);


?>

<h5>DB Panel - <?php echo $db; ?>
	
	| <a href='<?php echo URL."setup/grading";  ?>' > Setup</a>	
	| <a href='<?php echo URL."mis/dbsetup";  ?>' >DB Setup</a>	
	
	| <span class="txt-blue underline" onclick="xlastIDAll();return false;" >Last IDs</span>
	| <span class="txt-blue underline" onclick="xcountAll();return false;" >Counts</span>

	| <select onchange="gotoDB(this.value);"  >
		<option value="" >Choose One</option>
		<?php foreach($databases AS $val): ?>
			<option><?php echo $val; ?></option>
		<?php endforeach; ?>				
	</select>

	
</h5>

<p>
	<a href='<?php echo URL."$home/dbpanel/".DBG;  ?>' >DBG</a>
	| <a href='<?php echo URL."$home/dbpanel/".DBG;  ?>' >DBM</a>

	| <a href='<?php echo URL."$home/dbpanel/{$sy}".US.DBG;  ?>' ><?php echo $sy.'-DBG'; ?></a>
	| <a href='<?php echo URL."$home/dbpanel/{$sy}_".US.DBG;  ?>' ><?php echo $sy.'-DBM'; ?></a>
	
</p>


<?php 

?>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" ><th>#</th><th class="vc200" >Table - Last ID</th><th>LastID</th><th>Count</th></tr>
<?php for($i=0;$i<$num_tables;$i++): ?>
<?php $tbl = $tables[$i]['table']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td> <input id="<?php echo $i; ?>"  class="tbl pdl05"  value="<?php echo $tbl; ?>" readonly /> </td>
	<td><input class="vc70 right pdr05" id="lid-<?php echo $i; ?>" name="lasts[<?php echo $tbl; ?>]" value="<?php echo (isset($_SESSION['mis'][$db]['lasts'][$tbl]) && $_SESSION['mis'][$db]['lasts'][$tbl] !=NULL)? $_SESSION['mis'][$db]['lasts'][$tbl]: '0'; ?>" readonly /></td>
	<td><input class="vc70 right pdr05" id="ctid-<?php echo $i; ?>" name="counts[<?php echo $tbl; ?>]" value="<?php echo (isset($_SESSION['mis'][$db]['counts'][$tbl]) && $_SESSION['mis'][$db]['counts'][$tbl] !=NULL)? $_SESSION['mis'][$db]['counts'][$tbl]: '0'; ?>" readonly /></td>
</tr>
<?php endfor; ?>
</table>

	<p><input type="submit" name="submit" value="Sessionize"  /></p>

</form>

<!------------------------------------------------------------------------>

<script>

var gurl 	= 'http://<?php echo GURL; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';
var home 	= '<?php echo $home; ?>';
var db 		= '<?php echo $db; ?>';

$(function(){

})


</script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/mis.js"></script>
