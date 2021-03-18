<h3>
	Tests Level Crid (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" >SHD</span>

</h3>


<p>
	<?php echo $level['name'].' #'.$level['id']; ?> | 
	<?php foreach($levels AS $sel): ?>
		<?php $lid=$sel['id']; ?>
		<a href='<?php echo URL."tests/levelCrid/$lid/$sy"?>' ><?php echo $sel['code']; ?></a> | 
	<?php endforeach; ?>
</p>


<?php 
	pr("&nextsy");
	pr("params - lvl/sy");
	pr("&toPrevcrid");
	pr("&backToCrid");
	
	debug($rows[0]);

?>


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Birthdate</th>
	<th class="shd" >Ctp</th>
	<th>Name</th>
	<th>PrevCrid</th>
	<th><?php echo $sy; ?><br />Promlvl<br />Crid</th>	
	<th><?php echo $prevsy; ?><br />Psum<br />Lvl<br />Crid</th>
	<th><?php echo $sy; ?><br />Summ<br />Lvl<br />Crid</th>
<?php if(isset($_GET['nextsy'])): ?>
	<th><?php echo $nextsy; ?><br />Nsum<br />Lvl<br />Crid</th>	
<?php endif; ?>
	
	<th>Encrid</th>
	<th>Edit</th>
</tr>

<?php if(isset($_GET['nextsy'])): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['scid']; ?></td>
		<td><?php echo $rows[$i]['studcode']; ?></td>
		<td><?php echo $rows[$i]['birthdate']; ?></td>
		<td class="shd" ><?php echo $rows[$i]['ctp']; ?></td>
		<td><?php echo $rows[$i]['studname']; ?></td>
		<td><?php echo $rows[$i]['prevcrid']; ?></td>
		<td><?php echo $rows[$i]['promlvl'].'-'.$rows[$i]['promcrid']; ?></td>
		<td><?php echo $rows[$i]['psumlvl'].'-'.$rows[$i]['psumcrid']; ?></td>
		<td><?php echo $rows[$i]['summlvl'].'-'.$rows[$i]['summcrid']; ?></td>
		<td><?php echo $rows[$i]['nsumlvl'].'-'.$rows[$i]['nsumcrid']; ?></td>
		<td><?php echo $rows[$i]['encrid']; ?></td>
		<td><a href="<?php echo URL.'students/encrid/'.$rows[$i]['scid'].DS.$sy; ?>" >Edit</a></td>
		
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['scid']; ?></td>
		<td><?php echo $rows[$i]['studcode']; ?></td>
		<td><?php echo $rows[$i]['birthdate']; ?></td>
		<td class="shd" ><?php echo $rows[$i]['ctp']; ?></td>
		<td><?php echo $rows[$i]['studname']; ?></td>
		<td><?php echo $rows[$i]['prevcrid']; ?></td>
		<td><?php echo $rows[$i]['promlvl'].'-'.$rows[$i]['promcrid']; ?></td>
		<td><?php echo $rows[$i]['psumlvl'].'-'.$rows[$i]['psumcrid']; ?></td>
		<td><?php echo $rows[$i]['summlvl'].'-'.$rows[$i]['summcrid']; ?></td>
		<td><?php echo $rows[$i]['encrid']; ?></td>
		<td><a href="<?php echo URL.'students/encrid/'.$rows[$i]['scid'].DS.$sy; ?>" >Edit</a></td>		
	</tr>
	<?php endfor; ?>

<?php endif; ?>

</table>
</form>

<script>


$(function(){
	shd();
	
})

</script>

