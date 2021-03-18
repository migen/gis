<?php

// pr($rows[0]);

?>

<h5>
	<?php $brid=$_SESSION['brid']; ?>
	All Classrooms (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| Brid <?php echo $_SESSION['brid']; ?> | <?php $this->shovel('homelinks'); ?>
<?php if($_SESSION['srid']==RMIS): ?>
		Branch: <?php $d['branches']=$branches;$d['brid']=$brid;$this->shovel('selector_branches',$d); ?>			
<?php endif; ?>
		
	| <a href="<?php echo URL.'classrooms'; ?>" >Classrooms</a>
	| <a href="<?php echo URL.'cr/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'cr/tmps'; ?>" >Tmps</a>
	| <span class="u" onclick="traceshd();" >SHD</span>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Brid</th>
	<th>Adviser</th>
	<th>Level</th>
	<th>Section</th>
	<th class="shd" >Name</th>
	<th class="shd" >Label</th>
	<th>Count</th>
	<th>Axn</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="" ><?php echo $rows[$i]['branch_id']; ?></td>
	<td class="shd" ><?php echo $rows[$i]['adviser']; ?></td>
	<td><?php echo '#'.$rows[$i]['level_id'].' - '.$rows[$i]['level']; ?></td>
	<td><?php echo '#'.$rows[$i]['section_id'].' - '.$rows[$i]['section']; ?></td>
	<td class="shd" ><?php echo '#'.$rows[$i]['crid'].' - '.$rows[$i]['classroom']; ?></td>
	<td class="shd" ><?php echo $rows[$i]['label']; ?></td>
	<td><?php echo $rows[$i]['num_students']; ?></td>
	<td>
		  <a href="<?php echo URL.'cr/view/'.$rows[$i]['crid']; ?>" >View</a>
		| <a href="<?php echo URL.'cr/edit/'.$rows[$i]['crid']; ?>" >Edit</a>	
		| <a href="<?php echo URL.'cr/ltd/'.$rows[$i]['crid']; ?>" >Ltd</a>	
	</td>
</tr>
<?php endfor; ?>
</table>


<div class="ht50" ></div>


<script>

$(function(){
	// shd();
	
})

</script>
