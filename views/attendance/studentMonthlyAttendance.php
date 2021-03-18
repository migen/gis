<?php 

// pr($months[0]);
// pr($months);

// pr($attendance);

?>

<h5>
	Attendance Monthly by Student | SY <?php echo $sy; ?> - 
	<?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'attendance/studentQtr/'.$scid.DS.$sy.DS.$qtr; ?>" >Quarterly</a>	
	| <a href='<?php echo URL."conducts/editOne/$scid/$sy/$qtr"; ?>' >Conduct</a>	
	
</h5>

<p><?php echo $attendance['student']; ?></p>


<form method="POST" >

<table class="gis-table-bordered table-altrow table-fx" >

<tr class="headrow" >
	<th>Month</th>
	<th>Present</th>
	<th>Tardy</th>
</tr>

<?php foreach($months AS $month): ?>
<tr>
	<th><?php $mocode = $month['code']; echo $mocode; ?></th>
	<td><input class="vc50 center" name="<?php echo $mocode; ?>[present]" value="<?php echo $attendance[$mocode.'_days_present']; ?>" /></td>
	<td><input class="vc50 center" name="<?php echo $mocode; ?>[tardy]" value="<?php echo $attendance[$mocode.'_days_tardy']; ?>" /></td>
</tr>
<?php endforeach; ?>

<tr><th>Total</th>
<th><input class="vc50 center" name="total_days_present" value="<?php echo $attendance['total_days_present']; ?>" /></th>
<th><input class="vc50 center" name="total_days_tardy" value="<?php echo $attendance['total_days_tardy']; ?>" /></th>
</tr>

</table>

<p>
	<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" />
	
	<?php $crid = isset($_SESSION['crid'])? $_SESSION['crid']:1;  ?>	
	<button><a href='<?php echo URL."attendance/monthly/$crid/$sy/5"; ?>' >Class</a></button>
</p>

</form>