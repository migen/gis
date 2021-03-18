<?php 


// prx($data);

?>

<h3>
	Enrollment Paydates | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students'; ?>" >Student</a>
	| <a href="<?php echo URL.'students/enrollment'; ?>" >Enrollment</a>
	| <a href="<?php echo URL.'students/sectioner'; ?>" >Sectioner</a>
	| <a href="<?php echo URL.'enrollment/ledger'; ?>" >Ledger</a>

</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th class="vc200" >Paymode</th>
	<th class="vc150" >Paydates</th>
	<th class="vc150" >Grace <br />Period</th>
	<th class="" ></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$dates=$rows[$i]['duedates'];
	$grace_period=$rows[$i]['grace_period'];
	$dates_arr=explode(",",$dates);
	$grace_period_arr=explode(",",$grace_period);
	
	
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['paymode']; ?></td>
	<td>
		<?php  
			foreach($dates_arr AS $date){
				echo $date.'<br />';
			}			
		?>
	</td>
	<td>
		<?php  
			foreach($grace_period_arr AS $date){
				echo $date.'<br />';
			}			
		?>
	</td>		
	<td><a href="<?php echo URL.'paydates/edit/'.$rows[$i]['pkid']; ?>" >Edit</a></td>		
</tr>
<?php endfor; ?>
</table>
