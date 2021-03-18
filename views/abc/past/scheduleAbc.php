<?php 


function checkConflict($t1,$t2,$t3,$t4){
	$conflict=false;
	if($t1>$t3){
		if($t1<=$t4){
			$conflict=true;			
		}		
	}	/* one */

	if($t2>$t3){
		if($t2<=$t4){
			$conflict=true;			
		}		
	}	/* one */
	return $conflict;
	
	
}

function compareSchedules($curr,$next){
	// pr($curr);
	// $t1=date('H:i:s',$curr['time_beg']);
	$a=$curr['time_beg'];
	$t1=date('H:i:s',strtotime($curr['time_beg']));
	$t2=date('H:i:s',strtotime($curr['time_end']));
	$currday=$curr['day'];

	
	$t3=date('H:i:s',strtotime($next['time_beg']));
	$t4=date('H:i:s',strtotime($next['time_end']));
	
	$nextday=$next['day'];

	// checkConflict($t1,$t2,$t3,$t4)

	$conflict=false;
	if($t1>$t3){
		if($t1<=$t4){
			$conflict=true;			
		}		
	}	/* one */

	if($t2>$t3){
		if($t2<=$t4){
			$conflict=true;			
		}		
	}	/* one */
	return $conflict;
	
	
	
}	/* fxn */

?>

<h5>
	Schedule
	
	
	
</h5>

<?php


// exit;

?>



<table class="gis-table-bordered" >
<tr>
<th>Course</th>
<th>Day</th>
<th>Beg</th>
<th>End</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $j=$i+1; ?>
<?php 
	$has_conflict=@compareSchedules($rows[$i],$rows[$j]);
	
?>



<tr class="<?php echo ($has_conflict)? 'red':NULL; ?>" >
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['day']; ?></td>
	<td><?php echo $rows[$i]['time_beg']; ?></td>
	<td><?php echo $rows[$i]['time_end']; ?></td>
</tr>
<?php endfor; ?>
</table>


