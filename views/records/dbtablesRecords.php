<style>

	.vctable{ width:300px; } 

</style>

<h5>
	DB Tables (&unset)
	| <?php $this->shovel('homelinks'); ?>
	<?php $this->shovel('links_records'); ?>
	| <span class="u" onclick="traceshd();" >SHD</span>
	| <a href="<?php echo URL.'batch/update'; ?>" >Batch (set,update)</a>
	
</h5>


<div class="half" >
<?php for($s=0;$s<2;$s++): ?>
	<?php $schema=$schemas[$s]; ?>
	<table class="gis-table-bordered" >
		<tr>
			<th>#</th>
			<th><?php echo $schema; ?></th>
			<th></th>
			<th></th>
			<th></th>
			<th class="shd" ></th>
		</tr>
		<?php $count=$db[$s]['count']; ?>
		<?php for($i=0;$i<$count;$i++): ?>
		<?php $table=$db[$s]['tables'][$i]; ?>
			<tr>
				<td><?php echo $i+1; ?></td>
				<td class="vctable" ><?php echo $table; ?></td>
				<td><a href='<?php echo URL."records/set/{$schema}.{$table}"; ?>' >Set</a></td>
				<td><a href='<?php echo URL."records/add/{$schema}.{$table}"; ?>' >Add</a></td>
				<td><a href='<?php echo URL."records/setup/{$schema}.{$table}"; ?>' >Setup</a></td>
				<td class="shd" ><a href='<?php echo URL."records/truncate/{$schema}.{$table}"; ?>' >Truncate</a></td>
			</tr>
		<?php endfor; ?>

	</table><br />
	
<?php endfor; ?>	<!-- two schemas -->

<div class="ht100" >&nbsp;</div>

</div>	<!-- half -->


<!----------- ----->


<div class="third " >
<p>
	<ol>
		<li>Contacts - Admin, Teachers, Students</li>
		<li>Branches, Levels, <span class="b u" >Sections | 1-TMP, 2-OUT </span></li>
		<li>Classrooms First <span class="b u" > | 1-TMP, 2-OUT </span></li></li>
		<li>Subjects, Courses</li>
		<li>Ctype 1-Acad, 2-Trts/Cav, 3-Club, 5-Cond</li>
		<li>Criteria, Subcriteria (Traits), Components</li>
		<li>Sectioning Roster by: 1. Classroom 2. Level </li>
		<li>Load</li>
		<li>Scores and Grades Management</li>
	</ol>
</p>

<?php shovel('accor_treeset'); ?>

</div>	<!-- third -->

<script>

$(function(){
	shd();
	
	
})

</script>
