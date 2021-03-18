<h5>
	Test
	| <?php $this->shovel('homelinks','HR'); ?>
	
	
</h5>

<?php 

$dayno=0;

// $restdays=array(1,2,3);
$restdays=array(
	0=>0,
	1=>2,
	2=>3,
	
);
pr($restdays);

echo in_array($dayno,$restdays)? "selected":"not there";



?>

<form method="GET" >
<table class="gis-table-bordered" >
<tr><th>Restday</th>
<td>
	<input type="checkbox" name="post[rd]" value="1" <?php echo 'checked'; ?> />
</td>
</tr>

<tr><td colspan=2><input type="submit" name="submit" value="Submit"  /></td></tr>

</table>
</form>


