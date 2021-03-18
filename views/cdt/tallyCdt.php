<?php 
// pr($data);
$deciconducts=$_SESSION['settings']['deciconducts'];

// pr($rows[0]);

?>

<h5>
	Conduct Tally by Adviser
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."cdt/tally/$crid?edit"; ?>' >Edit</a>	
	| <a href='<?php echo URL."conducts/process/$crid"; ?>' >Process</a>	
	| <a href='<?php echo URL."conducts/sync/$crid"; ?>' >Sync</a>	
	| <a href='<?php echo URL."cdt/tally/$crid"; ?>' >Refresh</a>	
	
</h5>

<p>
	<table class="gis-table-bordered" >
		<tr>
			<th><?php echo '#'.$classroom['id'].'-'.$classroom['name'].' &nbsp; #'.$classroom['acid'].'-'.$classroom['adviser']; ?></th>

		<th>Status: <?php echo $is_locked? "Locked":"Open"; ?></th>	
		<th>
		<?php if(!$is_locked): ?>
				<a href="<?php echo URL.'finalizers/closeConduct/'.$crid.DS.$sy.DS.$qtr; ?>" >Finalize</a>
		<?php endif; ?>	
		<?php if($is_locked && $is_admin): ?>	
				<a href="<?php echo URL.'finalizers/openConduct/'.$crid.DS.$sy.DS.$qtr; ?>" >Open On</a>
		<?php endif; ?>	
		</th>
		</tr>	
	</table>
</p>


<h4 class="brown" >*Columns with 0 (zero) value will not be included in the average.</h4>




<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th colspan=3>Teacher</th>
	<?php for($i=0;$i<$numteacs;$i++): ?>
		<th style="height:120px;" ><span class="vertical" ><?php echo $teachers[$i]['name'].' #'.$teachers[$i]['tcid']; ?></span>
		</th>		
	<?php endfor; ?>	
	<th>DB</th>
	<th>Ave</th>
</tr>

<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<?php if(!$is_locked || $is_admin): ?>
		<?php for($i=0;$i<$numteacs;$i++): ?>	
			<?php $tcid=$teachers[$i]['tcid']; ?>	
			<th>
				<?php $is_mine=($ucid==$tcid)? true:false; ?>
				<?php if($is_mine || $is_admin): ?>
				<a href='<?php echo URL."cdt/grades/$crid/$tcid?edit"; ?>' >Edit</a>
				<?php endif; ?>
			</th>
		<?php endfor; ?>
	<?php else: ?>	
		<th colspan="<?php echo $numteacs; ?>" >Locked</th>
	<?php endif; ?>	
		
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php for($r=0;$r<$count;$r++): ?>
<?php $sum=0; $num=0; $ave=0; ?>
<tr>
	<td><?php echo $r+1; ?></td>
	<td><?php echo $rows[$r]['scid']; ?></td>
	<td><?php echo $rows[$r]['student']; ?></td>
	<?php for($i=0;$i<$numteacs;$i++): ?>
		<?php 
			$dbgr=number_format($rows[$r]['grade'],$deciconducts);
			$grade=number_format($grades[$i][$r]['grade'],$deciconducts); 
			
			if($grade>0){ $sum+=$grade; $num++; } 
		?>
		<td><?php echo $grade; ?></td>
	<?php endfor; ?>	
	<td><?php echo $dbgr; ?></td>
	<?php $num=($num<1)? 1:$num;$ave=($sum/$num); $ave=number_format($ave,$deciconducts);  ?>
	<?php $same=($dbgr==$ave)? true:false; ?>
	
	<th style="color:red;" >
		<?php if(isset($_GET['edit'])): ?>
			<?php if(!$same): ?>
				<input class="red vc50 center" name="posts[<?php echo $r; ?>][grade]" value="<?php echo $ave; ?>"  />
				<input type="hidden" name="posts[<?php echo $r; ?>][scid]" value="<?php echo $rows[$r]['scid']; ?>"  />
				<input type="hidden" name="posts[<?php echo $r; ?>][gid]" value="<?php echo $rows[$r]['gid']; ?>"  />
			<?php endif; ?>	<!-- not same -->
		<?php else: $val=($same)? NULL:$ave; echo $val; ?>
		<?php endif; ?>
	</th>	
</tr>
<?php endfor; ?>
</table>


<?php if(isset($_GET['edit'])): ?>
	<p><input type="submit" name="submit" value="Save"  /></p>
<?php endif; ?>



</form>


<div class="ht100" ></div>
