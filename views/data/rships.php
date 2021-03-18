<?php

include_once(SITE.'views/elements/lookups.php');



?>

<form method="POST" >
<table class="gis-table-bordered" >

<tr>
	<th>One Value</th>
	<td>
		<select name="one" >
			<?php foreach($lookups AS $k=>$v): ?>
				<option value="<?php echo $k; ?>" ><?php echo $v; ?></option>	
			<?php endforeach; ?>
		</select>
	</td>
	<td>
		<select name="many" >
			<?php foreach($rships AS $k=>$v): ?>
				<option value="<?php echo $k; ?>" ><?php echo $v; ?></option>	
			<?php endforeach; ?>
		</select>
	</td>
	<td></td>
</tr>

<tr>
	<td><br /><input name="val"   /></td>
	<td>one id<br /><input name="oneid" value="id" /></td>
	<td>many id<br /><input name="manyid" value="" /></td>	
	<td><br /><input type="submit" name="submit" value="Submit"  /></td>

</tr>





</table>
</form>


<?php 
	pr($results);
?>

