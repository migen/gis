<h5>
	Juxtapose - <?php echo $major['name']; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unilocks'; ?>" >Locks</a>
	
	
</h5>

<?php 
// pr($data);


?>



<p>
<?php foreach($majors AS $rec): ?>
<a href="<?php echo URL.'unicourses/juxtapose/'.$rec['id']; ?>" ><?php echo $rec['code']; ?></a> &nbsp; 
<?php endforeach; ?>
</p>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<?php foreach($rows AS $row): ?>
		<th><?php echo $row['classroom'].' #'.$row['crid']; ?></th>
	<?php endforeach; ?>
</tr>

<tr>
	<th>Courses</th>
	<?php for($i=0;$i<$count;$i++): ?>
		<th>
			<?php foreach($courses[$i] AS $recs): ?>
				<?php echo $recs['course'].' #'.$recs['crs']; ?><br />
			<?php endforeach; ?>
			
		</th>
	<?php endfor; ?>
</tr>


</table>

