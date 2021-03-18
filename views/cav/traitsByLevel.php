<?php 

$deciconducts  = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];


?>

<h5>
	Level Traits - <?php echo $level['name']; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."cav/traitsByLevel/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
<th>#</th>
<th>Classroom</th>
<th>Name</th>
<?php foreach($criterias AS $row): ?>
<th><?php echo $row['criteria_code'].'<br />'.$row['weight']; ?></th>
<?php endforeach; ?>

<th>DB<br />Ave</th>
<th>Row<br />Ave</th>

</tr>

<?php 
	@$eqwt = 1 / $num_criteria;

?>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>

	<?php $rowave=0; ?>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<?php 
			$ts = $cavs[$i][$j]['grade']; 
			$dg = $cavs[$i][$j]['letter']; 
			$wt = $cavs[$i][$j]['weight']; 
			if($wt < 100){
				$pnv = $ts * $wt / 100;			
			} else {
				$pnv = $ts*$eqwt;			
			}
		
			$rowave += $pnv;
		?>
		
		<td class="center"><?php echo $ts.'<br />'.$dg; ?></td>		
	<?php endfor; ?>	

	<td class="center" >
		<?php echo $rows[$i]['dbave']; ?>
		<br /><?php echo $rows[$i]['dbletter']; ?>		
	</td>

	<?php 
		$rowave=number_format($rowave,$decifconducts);?>
		<?php $dg = rating($rowave,$ratings); ?>		
		
	<?php $same = (($dg==$rows[$i]['dbletter']) && ($rowave==$rows[$i]['dbave']))? true:false; ?>
	
<?php if($same): ?>
		<td><?php $rowave.'<br />'.$dg; ?></td>
<?php else: ?>
	<td class="center <?php echo ($same)? NULL:'bg-red'; ?> " >
		<input class="center vc50" name="posts[<?php echo $i; ?>][ave]" 
			value="<?php echo $rowave; ?>" tabindex="2" />

		<br /><input class="center vc50" name="posts[<?php echo $i; ?>][dg]" value="<?php echo $dg; ?>" tabindex="4" />	
		<input type="hidden" class="center vc50" name="posts[<?php echo $i; ?>][sumid]" 
			value="<?php echo $rows[$i]['sumid']; ?>" />				
	</td>		
<?php endif;  ?>
	

	
</tr>
<?php endfor; ?>

</table>



<p><input type="submit" name="submit" value="Update" /></p>
</form>