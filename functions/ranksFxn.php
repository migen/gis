<?php


function getLevelRanksWithCondition($db,$lvl,$sy,$qtr,$cond=NULL,$limitcond=NULL){
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$free=isset($_GET['free'])? $_GET['free']:0;		
$freecond="AND cr.is_free<>1";

if($free==1){ $freecond="AND cr.is_free=1"; 
} elseif($free==2){ $freecond=""; }

$q="SELECT summ.scid,sumx.rank_level_ave_q{$qtr} AS rank,summ.ave_q{$qtr} AS genave,
		c.name AS name,c.name AS student,c.code AS studcode,cr.name AS classroom,sumx.*
	FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
	INNER JOIN {$dbg}.05_summext AS sumx ON summ.scid=sumx.scid
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	WHERE cr.level_id='$lvl' $cond $freecond AND c.is_active=1 ORDER BY genave DESC $limitcond; ";
debug($q,"ranksFxn: getLevelRanksWithCondition");
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function getLevelRanks($db,$dbg,$lvl,$qtr,$dbo=PDBO,$limitcond=NULL){
$dbo=PDBO;
$num=isset($_GET['num'])? $_GET['num']:1;		
$numcond=($num=='all')? NULL:" AND cr.num=$num ";
// if($num==1){ $numcond="AND cr.num=1"; 
// } elseif($free==2){ $freecond=""; }

$q="SELECT summ.scid,sumx.rank_level_ave_q{$qtr} AS rank,summ.ave_q{$qtr} AS genave,
		c.name AS name,c.name AS student,c.code AS studcode,cr.name AS classroom,sumx.*
	FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
	INNER JOIN {$dbg}.05_summext AS sumx ON summ.scid=sumx.scid
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	WHERE cr.level_id='$lvl' $numcond ORDER BY genave DESC $limitcond; ";
// pr($q);
debug($q,"ranksFxn: getLevelRanks");
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


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


function getSir($rows){
	/* 1 */
	$mr=mainGetSplitRanks($rows);
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


