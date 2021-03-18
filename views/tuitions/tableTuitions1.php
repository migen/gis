<?php 

// pr($_SESSION['q']);

?>

<h5>
	Tuition Table <span class="b" ><?php echo $sy; ?></span> | <?php $this->shovel('homelinks'); ?>
	<?php if($sy!=$_SESSION['year']): ?>
		| <a href="<?php echo URL.'tuitions/table/'.$_SESSION['year'];?>" ><?php echo $_SESSION['year']; ?></a>
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
	<th>Level</th>
	<th>Num</th>
	<th>Label</th>
	<th>Total</th>
	<th></th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php $pkid=$rows[$i]['pkid']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['lvlname']; ?></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td><?php echo $rows[$i]['label']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
	<td><a href="<?php echo URL.'tuitions/level/'.$rows[$i]['level_id'].DS.$sy; ?>" >Details</a></td>		
	<td><a href="<?php echo URL.'tuitions/edit/'.$pkid.DS.$sy; ?>" >Edit</a></td>		
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