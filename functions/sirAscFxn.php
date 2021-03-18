<?php




/* main function */	
function mainGetSplitRanksAsc($rows){	// total desc - getRanks
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
		$rows[$i]['value']=$rows[$i]['total'];
		$rows[$i]['next']=@$rows[$j]['total'];
		$rows[$i]['has_equal']=1;	
		$rows[$i]['ctr']=$ctr;				
		$rows[$i]['prevsum']=@$rows[$h]['sum'];
		$equals[$r1][]=$rows[$i];		
		if(@$rows[$j]['total']>$rows[$i]['total']){			
			if($rows[$i]['total']!=@$rows[$h]['total']){
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


function getSirAsc($rows){
	/* 1 */
	$mr=mainGetSplitRanksAsc($rows);
	$rows=$mr['rows'];
	
	/* 2 */
	$equals=$mr['equals'];
	$max=@max($cr);
	$oldkeys=array_keys($equals);	
	
	/* 3 */
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
	
	/* 4 */
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
	return $rows;
	
	
}	/* fxn */






// sortRanks
// SET @r=0; UPDATE records SET rank= @r:= (@r+1) where type = 2 ORDER BY seconds DESC LIMIT 10000;


