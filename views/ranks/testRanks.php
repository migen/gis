<?php 


$ti=isset($_GET['ti'])? $_GET['ti']:0;
pr($rows[$ti]);

/* main function */
function mainGetSplitRanks($rows){	// genave_array	- getRanks
	$ranks=array();
	$ct=0;	// table row count, index + 1
	$sum=0;	// triangular number or Factorial Sum of row count 
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
		$rows[$i]['eq_count']=1;		
		$rows[$i]['value']=$rows[$i]['genave'];
		$rows[$i]['next']=@$rows[$j]['genave'];
		$rows[$i]['has_equal']=1;	
		$rows[$i]['ctr']=$ctr;				
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
	$mr['rows']=&$rows;
	$mr['equals']=&$equals;
	return $mr;
}	/* fxn */


/* callback FP1 */
$mr=mainGetSplitRanks($rows);
$rows=$mr['rows'];
$equals=$mr['equals'];
$oldkeys=array_keys($equals);

/* callback FP2 */
$newkey=0;
$eq_ranks=array();
$eq_counts=array();
foreach($equals AS $eq){
	$equals[$newkey]=$eq;
	$oldkey=$oldkeys[$newkey];
	unset($equals[$oldkey]);
	$eq_count=count($eq);
	$max=$eq[$eq_count-1]['sum'];
	$min=$eq[0]['prevsum'];	
	$rank=($max-$min)/$eq_count;
	$eq_counts[$newkey]=$eq_count;
	$eq_ranks[$newkey]=$rank;
	$newkey++;
}	/* fxn */

$i=0;
foreach($equals AS $eq){
	$rank=$eq_ranks[$i];
	$eq_count=$eq_counts[$i];
	foreach($eq AS $row){
		$row_index=$row['i'];
		$rows[$row_index]['rank']=$rank;
		$rows[$row_index]['eq_count']=$eq_count;
	}
	$i++;	
}	/* fxn */


?>

<h5>
	Split Iterative Ranking / SIR (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 	
	| <span class="txt-blue u" onclick="btnExport" >Export</span>
	| <span class="u" >&ti (test index)</span>
	| <span class="u" >&limit</span>

</h5>


<?php pr($rows[$ti]); ?>

<table id="tblExport" class="gis-table-bordered table-altrow table-fx center" >
<tr class="headrow" >
<th>#</th>
<th>ID</th>
<th class="vc250 left" >Name</th>
<th class="center" >Curr<br />(I)</th>
<th class="center" >Next<br />(J)</th>
<th>R1</th>
<th>EV</th>
<th>H</th>
<th>I</th>
<th>J</th>
<th>Ct</th>
<th>Sum</th>
<th>Gen<br />Ave</th>
<th>Ctr</th>
<th>Has<br />EQ</th>
<th>EQ<br />Ct</th>
<th>Ptr</th>
<th>R2</th>

</tr>
<?php $r1=1; ?>
<?php for($i=0;$i<$count;$i++): ?>


<tr>	
	<td><?php echo $rows[$i]['ct']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td class="left" ><?php echo ucfirst($rows[$i]['name']); ?></td>
	<td class="rigth" ><?php echo number_format($rows[$i]['genave'],2); ?></td>
	<td><?php echo number_format($rows[$i]['next'],2); ?></td>
	<td><?php echo $r1; ?></td>
	<?php ($rows[$i]['genave']>$rows[$i]['next'])? $r1+=1:$r1; ?>
	<td><?php echo $rows[$i]['rank']+0; ?></td>
	<td><?php echo $rows[$i]['h']; ?></td>
	<td><?php echo $rows[$i]['i']; ?></td>
	<td><?php echo $rows[$i]['j']; ?></td>
	<td><?php echo $rows[$i]['ct']; ?></td>
	<td><?php echo $rows[$i]['sum']; ?></td>
	<td><?php echo number_format($rows[$i]['genave'],2); ?></td>
	<td><?php echo $rows[$i]['ctr']; ?></td>
	<td><?php echo ($rows[$i]['has_equal'])? 1:'-'; ?></td>
	<td><?php echo $rows[$i]['eq_count']; ?></td>
	<td><?php echo $rows[$i]['ptr']; ?></td>
	<td><?php echo $rows[$i]['rank']; ?></td>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})

</script>

