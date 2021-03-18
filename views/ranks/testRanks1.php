<style>


</style>

<?php 




function gr($rows){	// genave_array	- getRanks
	$ranks=array();
	$ct=0;	// table row count, index + 1
	$sum=0;	// triangular number or sum factorial of row count 
	$ctr=1;	// running count number of similar genave
	$h=0;	// prev
	$i=0;	// index
	$j=0;	// next
	$r1=1;	// ranking method 1
	$equals=array();
	foreach($rows AS $g){
		$ct++;
		$sum+=$ct;
		$h=$i-1;	
		$j=$i+1;	
		$rows[$i]['h']=$h;	
		$rows[$i]['i']=$i;	
		$rows[$i]['j']=$j;	
		$rows[$i]['ct']=$ct;
		$rows[$i]['sum']=$sum;		
		$rows[$i]['value']=$rows[$i]['genave'];
		$rows[$i]['next']=@$rows[$j]['genave'];
		$rows[$i]['has_equal']=1;	
		$rows[$i]['ctr']=$ctr;				
		// $equals[$r1][]=$rows[$i];
		$rows[$i]['prevsum']=@$rows[$h]['sum'];
		$equals[$r1][]=$rows[$i];
		
		if(@$rows[$j]['genave']<$rows[$i]['genave']){			
			if($rows[$i]['genave']!=@$rows[$h]['genave']){
				$rows[$i]['rank']=$ct;
				$rows[$i]['has_equal']=0;
				$equals[$r1][]=$rows[$i];
				$rows[$i]['ptr']=0;											
				unset($equals[$r1]);				
			} else {
				$rows[$i]['rank']=$r1;						
				$rows[$i]['ptr']=$r1;									
			}
			$ctr=1;
			$r1++;
		} else {
			$ctr++;
			$rows[$i]['rank']=$r1;
			$rows[$i]['ptr']=$r1;			
		}		
		$i++;
	}	/* foreach */
	// unset($equals[$r1]);
	$mr['rows']=&$rows;
	$mr['equals']=&$equals;
	return $mr;

}	/* fxn */

// $x=$rows[]

function gm($rows,$ptr){	// getMax
	$ctr_arr=array();
	foreach($rows AS $r){
		if($r['ptr']==$ptr){
			$ctr_arr[]=$r['ctr'];
			// pr($r);
			
		}
	}
	return $ctr_arr;
}	/* fxn */




function gr1($gr){ foreach($gr AS $g){ pr($g['genave']); } }	/* fxn-ok */


/* step 1 */
$mr=gr($rows);
$rows=$mr['rows'];
$equals=$mr['equals'];
$cr=gm($rows,2);
$max=max($cr);

// pr($rows);
// pr($equals);

/* step 2 */
foreach($equals AS $eq){
	// pr($eq);
	$eq_num=count($eq);
	pr($eq_num);
	$max=$eq[$eq_num-1]['sum'];
	$min=$eq[0]['prevsum'];	
	echo "max: $max <br />";
	echo "min: $min <br />";
	$rank=($max-$min)/$eq_num;
	pr($rank);
	
	echo "<hr />";	
	
	
	
}

// exit;

// pr($rows[1]);


?>

<h5>
	Ranks
	| <?php $this->shovel('homelinks'); ?>

</h5>


<table class="gis-table-bordered table-altrow " >
<tr><th>#</th><th>Scid</th><th>Student</th><th>Genave<br />I</th>
<th>Next<br />J</th>
<th>R1</th>
<th>Shld</th>
<th>I</th>
<th>Ct</th>
<th>Sum</th>
<th>GA</th>
<th>R2</th>
<th>Ctr</th>
<th>Has<br />EQ</th>

</tr>
<?php $r1=1; ?>
<?php for($i=0;$i<$count;$i++): ?>


<tr>	
	<td><?php echo $rows[$i]['ct']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td class="rigth" ><?php echo number_format($rows[$i]['genave'],2); ?></td>
	<td><?php echo number_format($rows[$i]['next'],2); ?></td>
	<td><?php echo $r1; ?></td>
	<?php ($rows[$i]['genave']>$rows[$i]['next'])? $r1+=1:$r1; ?>
	<td><?php echo $rows[$i]['should']+0; ?></td>
	<td><?php echo $rows[$i]['i']; ?></td>
	<td><?php echo $rows[$i]['ct']; ?></td>
	<td><?php echo $rows[$i]['sum']; ?></td>
	<td><?php echo number_format($rows[$i]['genave'],2); ?></td>
	<td><?php echo $rows[$i]['rank']; ?></td>
	<td><?php echo $rows[$i]['ctr']; ?></td>
	<td><?php echo ($rows[$i]['has_equal'])? 1:'-'; ?></td>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>
