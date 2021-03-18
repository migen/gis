<h5>
	My Club
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/notes'; ?>" >Notes</a>
	
	
	
</h5>

<?php 


?>


<?php foreach($clubs AS $row): ?>
<h5><?php echo '#'.$row['id'].' - '.$row['name']; ?></h5>
<table class="gis-table-bordered table-altrow" >
<tr><td class="vc150" ><a href="<?php echo URL.'clubs/members/'.$row['id']; ?>" >Members</a></td></tr>
<tr><td><a href="<?php echo URL.'clubs/scores/'.$row['id']; ?>" >Scores</a></td></tr>
<tr><td><a href="<?php echo URL.'clubs/grades/'.$row['id']; ?>" >Grades</a></td></tr>


</table>
<br />
<?php endforeach; ?>


