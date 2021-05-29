<style>

.indented{ text-indent:20px; }


</style>

<?php 

// pr($_SESSION['q']);
// pr($rows[0]);

?>

<h5>
	Tuition Table <span class="b" ><?php echo $sy; ?></span> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if($sy!=$_SESSION['year']): ?>
		| <a href="<?php echo URL.'tuitions/table/'.$_SESSION['year'];?>" ><?php echo $_SESSION['year']; ?></a>
	<?php endif; ?>
		| <a href="<?php echo URL.'tfees/table/'.$sy;?>" >Tuitions1</a>

	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'setupTfees/lockTuitionLevels/'.$sy;?>" >Lock All</a>
		| <a href="<?php echo URL.'setupTfees/openTuitionLevels/'.$sy;?>" >Open All</a>	
	<?php endif; ?>


<?php 
	$d['sy']=$sy;$d['repage']="tuitions/table";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."tuitions/level/".$sel['id']."/$sy?num=1"; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow"  >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Level</th>
	<th>Num</th>
	<th>Label</th>
	<th>Total</th>
	<th>Status</th>
	<th></th>
	<th></th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php $pkid=$rows[$i]['pkid']; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['lvlname']; ?></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td><?php echo $rows[$i]['label']; ?></td>	
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
	<td><?php echo ($rows[$i]['is_finalized']==1)? 'Locked':'Open'; ?></td>		
	<?php $num_suffix=($rows[$i]['num']>1)? '&num='.$rows[$i]['num']:NULL; ?>
	<td><a href="<?php echo URL.'tuitions/level/'.$rows[$i]['level_id'].DS.$sy.$num_suffix; ?>" >Details</a></td>		
	<td><a href="<?php echo URL.'tuitions/edit/'.$pkid.DS.$sy; ?>" >Edit</a></td>		
	<td><a href="<?php echo URL.'tuitions/view/'.$rows[$i]['level_id'].DS.$sy.$num_suffix; ?>" >View</a></td>			
</tr>
<?php endfor; ?>

</table>

<p>
	<input class="hd" type="submit" name="update" value="Update" onclick="return confirm('Sure?');" />
</p>

</form>


<script>

$(function(){
	hd();
	
})

</script>