<?php



function updatePayableBalance($db,$payable,$payments){	
	$dbo=PDBO;
	// pr($payable);
	// ct-computed
	$data['paid']=0;
	$ct_paid=0;
	$ct_balance=$payable['amount'];
	
	$db_paid=$payable['paid'];
	$db_balance=$payable['balance'];
	$pkid=$payable['pkid'];
	
	foreach($payments AS $payment){
		if(($payable['feetype_id']==$payment['feetype_id']) && ($payable['ptr']==$payment['ptr'])){
			$ct_paid=$ct_paid+$payment['amount'];						
		}		
	}
	$data['paid']=$ct_paid;	
	$data['balance']=$ct_balance=$ct_balance-$ct_paid;

	$is_updated_balance=(round($ct_balance,2)==round($db_balance,2))? true:false;
	$is_updated_paid=(round($ct_paid,2)==round($db_paid,2))? true:false;

	if((!$is_updated_balance) || (!$is_updated_paid)){
		$q="UPDATE {$dbo}.30_payables SET paid='".round($ct_paid,2)."',balance='".round($ct_balance,2)."' WHERE id=$pkid LIMIT 1; ";
		$db->query($q);
	}
	
	return $data;
}	/* fxn */




function syncTfeePayables($db,$sy,$scid,$adjustedPayables,$tfeePayables,$scidAssessment){
		
	$dbo=PDBO;
	$student=$scidAssessment;
	$arp=$adjustedPayables;
	$tfd=$tfeePayables;
	$tfeePayables=$tfd['rows'];
	$num_tfeePayables=$tfd['count'];
	
	extract($student);
	extract($arp);
		
	$ar=buildArray($tfeePayables,'ptr');
	
	
	$did_delete=false;
	if($period<count($ar)){
		$did_delete=true;
		for($i=$period;$i<count($ar);$i++){
			$id=$tfeePayables[$i]['id'];
			$q="DELETE FROM {$dbo}.30_payables WHERE id=$id LIMIT 1;";
			$db->querysoc($q);
		}
	}
		
	$did_insert=false;
	for($i=1;$i<=$period;$i++){
		if(!in_array($i,$ar)){
			$did_insert=true;
			$q="INSERT INTO {$dbo}.30_payables(sy,scid,feetype_id,amount,ptr)VALUES($sy,$scid,1,'".$adjusted_periodic."',$i); ";
			$db->query($q);
		} else {
			if($tfeePayables[$i-1]['amount']!=$adjusted_periodic){
				$q="UPDATE {$dbo}.30_payables SET amount='$adjusted_periodic' WHERE id='".$tfeePayables[$i-1]['id']."' LIMIT 1; ";
				$db->query($q);				
			}

		}
	}	/* for */

	if($did_insert){
		$tfd=getTfeesFromPayables($db,$sy,$scid);
		$tfeePayables=$tfd['rows'];
		$num_tfeePayables=$tfd['count'];

		
	} 	/* re-fetch tfeePayables */
	
	$did_crud=($did_delete || $did_insert)? true:false;	
	return $did_crud;
	
	
}	/* fxn */


// customArraySum
function summateAmount($arr,$field='amount',$include_discounts=false){
	$sum=0;
	if($include_discounts){
		foreach($arr AS $row){
			$sum+=$row[$field];
		}		
	} else {
		foreach($arr AS $row){
			if($row['is_discount']!=1){
				$sum+=$row[$field];				
			}
		}				
	}
	return $sum;
	
}	/* fxn */

function scidPaymentsAll($db,$sy,$scid,$fields=NULL){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q = "SELECT p.*,ft.name AS feetype,p.id AS payment_id,pt.name AS paytype,p.id AS pkid
			FROM {$dbo}.30_payments AS p 
			LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id=ft.id
			LEFT JOIN {$dbo}.03_paytypes AS pt ON p.paytype_id=pt.id
			WHERE p.sy=$sy AND p.scid=$scid 
			ORDER BY p.date,p.feetype_id,p.ptr; ";
	debug("EnrollmentFxn: scidPayments: ".$q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	debug($rows);
	return $rows;	
	
}	/* fxn */


function scidPaymentsAllXXX($db,$sy,$scid,$fields=NULL){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q = "SELECT p.*,ft.name AS feetype,p.id AS payment_id,pt.name AS paytype,p.id AS pkid
			FROM {$dbo}.30_payments AS p 
			LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id=ft.id
			LEFT JOIN {$dbo}.03_paytypes AS pt ON p.paytype_id=pt.id
			WHERE p.sy=$sy AND p.scid=$scid 
			ORDER BY p.date,p.feetype_id,p.ptr; ";
	debug("EnrollmentFxn: scidPayments: ".$q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	debug($rows);
	return $rows;	
	
}	/* fxn */


function getTfeeDuedates($db,$sy,$paymode_id){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.03_paydates WHERE sy=$sy AND paymode_id=$paymode_id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
	
}	/* fxn */

// * created/ updated 20200403
function getOrdinalEnrollment($num){
	switch($num){
		case 1: $ordinalnum = "1st"; break;
		case 2: $ordinalnum = "2nd"; break;
		case 3: $ordinalnum = "3rd"; break;
		default: $ordinalnum = $num."th"; break;	
	}
	return $ordinalnum;
}	/* fxn */

function enrollStudent($db,$sy,$scid,$post_crid){	// linked - 1. ajax/xenrollment 2. sectioning
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	/* 1 */
	$q="SELECT c.sy,c.id AS scid,en.id AS enid,summ.id AS summid,c.crid AS contcrid,en.crid AS encrid,summ.crid AS summcrid
	FROM {$dbo}.`00_contacts` AS c LEFT JOIN {$dbo}.`05_enrollments` AS en ON (en.sy=$sy && en.scid=c.id)
		LEFT JOIN {$dbg}.`05_summaries` AS summ ON summ.scid=c.id WHERE c.id=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();	
	/* 2 */
	$q="";			
	if($sy==DBYR){	/* current */
		if($row['contcrid']!=$post_crid){ $q.="UPDATE {$dbo}.00_contacts SET sy=$sy,prevcrid=crid,crid=$post_crid WHERE id=$scid LIMIT 1;"; }		
	}	/* current */
	
	/* 1 - contacts */			
	if($row['encrid']!=$post_crid){ $q.="UPDATE {$dbo}.05_enrollments SET crid=$post_crid WHERE id=".$row['enid']." LIMIT 1;"; }
	if($row['summcrid']!=$post_crid){ $q.="UPDATE {$dbg}.05_summaries SET crid=$post_crid WHERE id=".$row['summid']." LIMIT 1;"; }
	if(!empty($q)){ $sth=$db->query($q); return ($sth)? true:false; }	
	
	
} 	/* fxn */	


	
function rowIsStudent($row){
	if($row['role_id']!=RSTUD){ echo "<h3 style='color:brown;'>UCID #".$row['ucid']." NOT a Student.</h3>"; return false; } 
	return true;		
}	/* fxn */


function checkContact($db,$contact_id){
	$dbo=PDBO;$q="SELECT id FROM  {$dbo}.`00_contacts` WHERE id=$contact_id LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();		
	if(empty($row)){ echo "<h3 style='color:brown;'>Contact ID #$contact_id does NOT exist.</h3>"; return false; } 
	return true;
}	/* fxn */


function sectioningStudent($db,$sy,$scid,$fields=NULL){	

$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$has_axis=&$_SESSION['settings']['has_axis'];

	$q = "SELECT $fields c.id AS ucid,c.parent_id AS pcid,c.name AS studname,c.code AS studcode,c.role_id,
			en.scid AS enscid,en.id AS enid,summ.scid AS summscid,summ.id AS summid,
			$sy AS sy,c.prevcrid,
			c.crid AS contcrid,en.crid AS encrid,summ.crid AS summcrid,
			cr.name AS classroom,
			l.id AS currlvl,l.name AS currlevel
		";
		$q.=" FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy && en.scid=c.id)
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid=c.id			
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id=l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id=sxn.id 
		";			
		$q.=" WHERE c.id=$scid LIMIT 1; ";					
	debug("EnrollmentFxn: SectioningStudent: ".$q);
	$sth=$db->querysoc($q);
	return $sth->fetch();
}	/* fxn */



function getEnsummByStudent($db,$scid){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.05_enrollment_summaries WHERE scid=$scid;  ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();		
	return $row;
}	/* fxn */


function parsePayables($payables){
	$data['discounts']=array();
	$data['nondiscounts']=array();
	$data['total_discount']=0;
	$data['total_nondiscount']=0;
	$data['previous_balance']=0;
	foreach($payables AS $row){
		// if($row['feetype_id']==3) continue;
		if($row['feetype_id']==3){
			$data['previous_balance']+=$row['amount'];
			continue;
		};

		if($row['is_discount']==1){
			$data['total_discount']+=$row['amount'];
			array_push($data['discounts'],$row);
		} else {
			if($row['feetype_id']!=1){
				$data['total_nondiscount']+=$row['amount'];
				array_push($data['nondiscounts'],$row);							
			}
		}
	}	
	$data['has_previous_balance']=($data['previous_balance']>0)? true:false;
	return $data;
}	/* fxn */



function parsePayments($payments){
	$data['tfees']=array();
	$data['nontfees']=array();
	$data['total_payment_tfees']=0;
	$data['total_payment_nontfees']=0;
	$data['total_payment']=0;
	foreach($payments AS $row){
		$data['total_payment']+=$row['amount'];
		if($row['feetype_id']==1){
			$data['total_payment_tfees']+=$row['amount'];
			array_push($data['tfees'],$row);
		} else {
			$data['total_payment_nontfees']+=$row['amount'];
			array_push($data['nontfees'],$row);
		}
	}
	// pr($data);
	return $data;
}	/* fxn */


function scidAssessment($db,$sy,$scid,$fields=NULL){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;				
	
	
	
	$q = "SELECT cr.name AS classroom,c.name AS studname,c.code AS studcode,
				summ.paymode_id,pm.name AS paymode,
				cr.level_id,cr.section_id,cr.id AS crid,cr.num,l.name AS level,t.total,
				d.amount AS tuition_amount
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
			LEFT JOIN {$dbo}.03_paymodes AS pm ON summ.paymode_id=pm.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON (cr.level_id=t.level_id AND cr.num=t.num)
			LEFT JOIN {$dbo}.`03_tfeedetails` AS d ON (d.sy=$sy AND d.level_id=t.level_id AND d.num=t.num AND d.feetype_id=1)
			WHERE c.id=$scid AND t.sy=$sy; ";
			pr($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();	
	pr($row);
	debug("EnrollmentFxn: assessmentStudent: ".$q);	debug($row);
	$num=$row['num'];$level_id=$row['level_id'];	
	if(empty($row)){ echo "<h3>Please check <a href='".URL."students/leveler/{$scid}' >Leveler</a></h3>"; exit; }
		
	$q="SELECT sum(amount) AS previous_balance FROM {$dbo}.30_payables WHERE scid=$scid AND feetype_id=3;  ";
	// pr($q);
	$sth=$db->querysoc($q);
	$row1=$sth->fetch();	

	$q="SELECT sum(amount) AS paid_previous_balance FROM {$dbo}.30_payments WHERE scid=$scid AND feetype_id=3;  ";
	$sth=$db->querysoc($q);
	$row2=$sth->fetch();		

	// 2021-jan todo
	
	$row=array_merge($row,$row1,$row2);	
	// $row['remaining_previous_balance']=$row['previous_balance']-$row['paid_previous_balance'];

	
	if(($num>1) AND ($level_id>13)){
		$q="SELECT total FROM {$dbo}.03_tuitions WHERE sy=$sy AND level_id=$level_id AND num=$num LIMIT 1;";
		$sth=$db->querysoc($q);$brow=$sth->fetch();$row['total']=$brow['total'];		
	}	/* shs */	
	
	// payablesArray
	$data['payables']=$payables=scidPayables($db,$sy,$scid,$fields=NULL);
	$data['payments']=$payments=scidPayments($db,$sy,$scid,$fields=NULL);				
	// $payarr=parsePayables($payables);	
	$payableRow=parsePayables($payables);	
	extract($payableRow);
	
	// discounts and nondiscounts
	// $row['previous_balance']=$previous_balance;
	// $row['has_previous_balance']=$has_previous_balance;
	$row['total_adjustment']=$total_nondiscount-$total_discount;
	
	$row=array_merge($row,$payableRow);	
	$data['student']=$row;
	
	
	return $data;
}	/* fxn */

function scidTfeedetails($db,$sy,$scid,$num=1){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q = "SELECT d.*,f.name AS feetype,f.id AS tfid,f.parent_id AS tfsupid
			FROM {$dbg}.05_summaries AS summ			
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbo}.03_tfeedetails AS d ON cr.level_id=d.level_id
			INNER JOIN {$dbo}.03_feetypes AS f ON d.feetype_id=f.id
			WHERE summ.scid=$scid AND d.num=$num AND d.sy=$sy AND d.is_displayed=1 AND d.in_total=1; ";				
	debug("EnrollmentFxn: scidTfeedetails: ".$q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	// return $row['total_discount'];
}	/* fxn */


function scidTotalDiscount($db,$sy,$scid){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q = "SELECT sum(p.amount) AS total_discount
			FROM {$dbo}.30_payables AS p 
			LEFT JOIN {$dbo}.03_feetypes AS f ON p.feetype_id=f.id
			WHERE p.scid=$scid AND p.sy=$sy AND f.is_discount=1; ";
	debug("EnrollmentFxn: scidPayables: ".$q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	// pr($row);
	return $row['total_discount'];
}	/* fxn */


function scidPayables($db,$sy,$scid,$fields=NULL){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q = "SELECT ft.name AS feetype,p.*,p.id AS payable_id,p.id AS pkid,ft.is_discount,ft.code AS feetype_code
			FROM {$dbo}.30_payables AS p 
			LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id=ft.id
			WHERE p.scid=$scid AND p.sy=$sy ORDER BY ft.position,p.ptr; ";
	debug("EnrollmentFxn: scidPayables: ".$q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	debug("&payables");
	if(isset($_GET['payables'])){ pr($rows); }	
	return $rows;
}	/* fxn */


function scidPayments($db,$sy,$scid,$fields=NULL){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q = "SELECT p.*,ft.name AS feetype,p.id AS payment_id,pt.name AS paytype,p.id AS pkid
			FROM {$dbo}.30_payments AS p 
			LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id=ft.id
			LEFT JOIN {$dbo}.03_paytypes AS pt ON p.paytype_id=pt.id
			WHERE p.sy=$sy AND p.scid=$scid AND p.in_tuition=1
			ORDER BY p.date,p.feetype_id,p.ptr; ";
	debug("EnrollmentFxn: scidPayments: ".$q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	debug("&payments");
	if(isset($_GET['payments'])){ pr($rows); }
	return $rows;
}	/* fxn */



function syncEnrollmentSummaryByStudentNeeded($db,$sy,$scid,$row){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="";
	if(!isset($row['enscid'])){ $q.="INSERT INTO {$dbo}.05_enrollments(`sy`,`scid`)VALUES ($sy,$scid);"; }	
	if(!isset($row['summscid'])){ $q.="INSERT INTO {$dbg}.05_summaries(`scid`)VALUES($scid);"; }	
	if(!empty($q)){ $db->query($q); return true; } else { return false; }	
}	/* fxn */


function closeRangeFromLevelClassrooms($db,$level_id){
	$dbo=PDBO;$dbg=PDBG;$brid=$_SESSION['brid'];
	$lc=$_SESSION['level_classrooms'];

	$a=($level_id>1)? $level_id-1:1;
	$b=$level_id;
	$c=$level_id+1;
	$ar=isset($lc[$a])? $lc[$a]:array();
	$br=isset($lc[$b])? $lc[$b]:array();
	$cr=isset($lc[$c])? $lc[$c]:array();
	
	$crr=($a>0)? array_merge($ar,$br,$cr):array_merge($br,$cr);
	return $crr;
	
}	/* fxn */



function promotingStudent($db,$sy,$scid,$fields=NULL){	

$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$has_axis=&$_SESSION['settings']['has_axis'];

	$q="SELECT $fields c.id AS ucid,c.parent_id AS pcid,c.name AS studname,c.code AS studcode,c.role_id,
			summ.id AS summid,summ.scid AS summscid,summ.crid AS summcrid,
			summ.promlvl,summ.promsy,
			cr.name AS classroom,cr.level_id,cr.section_id,
			l.name AS curr_level,nl.name AS next_level,
			sxn.name AS section,
			l.id AS currlvl,(l.id+1) AS nextlvl
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid=c.id			
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id=l.id
			LEFT JOIN {$dbo}.`05_levels` AS nl on (cr.level_id+1)=nl.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id=sxn.id
			WHERE c.id=$scid LIMIT 1;
		";						
	debug("EnrollmentFxn: PromotingStudent: ".$q);
	$sth=$db->querysoc($q);
	return $sth->fetch();
	// exit;
	
}	/* fxn */


function promoteStudent($db,$scid,$promlvl){	// linked - 1. ajax/xenrollment 2. sectioning
	$dbo=PDBO;$dbg=PDBG;
	$q="UPDATE {$dbg}.05_summaries SET promlvl=$promlvl,promsy=".(DBYR+1)." WHERE scid=$scid LIMIT 1;"; 	 
	$db->query($q); 	
} 	/* fxn */	


function getAssessment($assessed,$paymode){
	switch($paymode){
		case 'yearly':
			return array('amount'=>$assessed,'count'=>1);break;
		case 'semestral':
			$assessed*=1.05;
			return array('amount'=>$assessed/2,'count'=>2);break;			
			break;
		case 'monthly':
			$assessed*=1.375;
			return array('amount'=>$assessed/10,'count'=>10);break;			
		default:
			$assessed*=1.075;
			return array('amount'=>$assessed/4,'count'=>4);break;			
	}
	
}	/* fxn */


function getPaydatesByPaymodeId($db,$paymode_id,$sy){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT * FROM {$dbo}.03_paydates WHERE paymode_id=$paymode_id LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;

} 	/* fxn */	


function explodePaydatesToArray($paydates){
	$string=$paydates['duedates'];
	$data['rows']=explode(",",$string);
	$data['count']=count($data['rows']);
	return $data;	
}	/* fxn */


function scidSiblings($db,$scid,$sy=DBYR){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	/* process */
	$q="SELECT family_id FROM {$dbo}.00_family_members WHERE scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['family']=$sth->fetch();
	$data['family_id']=$family_id=$data['family']['family_id'];
	/* process */
	$q = "SELECT c.code AS studcode,c.name AS studname,m.*,m.id AS pkid,f.name AS family
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbo}.00_family_members AS m ON m.scid=c.id
		INNER JOIN {$dbo}.00_families AS f ON f.id=m.family_id 
		WHERE m.family_id=$family_id; ";
	debug("EnrollmentFxn: scidSiblings: ".$q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
}	/* fxn */



function getAssessmentDataForClearance($db,$sy,$scid){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	

	/* 1 */
	$q="SELECT cr.level_id,cr.num FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid WHERE summ.scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$lvl=$row['level_id'];
	$num=$row['num'];
	$data['num']=$num=isset($_GET['num'])? $_GET['num']:$num;	

	/* 2 */
	$star=scidAssessment($db,$sy,$scid,$fields=NULL);		
	$data['student']=$student=$star['student'];
	$data['payables']=$star['payables'];
	$data['payments']=$star['payments'];
	
	
	$data['paydates_array']=$paydates_array=getTfeeDuedates($db,$sy,$data['student']['paymode_id']);
	$data['tfee_duedates']=$paydates_array['duedates'];
	$data['tfee_grace_period']=$paydates_array['grace_period'];
	$data['duedates_count']=$paydates_array['count'];

	$data['tfee_duedates_arr']=explode(",",$data['tfee_duedates']);
	$data['tfee_grace_period_arr']=explode(",",$data['tfee_grace_period']);
	
	$data['paymode_id']=$paymode_id=$student['paymode_id'];	
	$data['paydates']=$paydates=getPaydatesByPaymodeId($db,$paymode_id,$sy);
	$data['pdr']=$pdr=explodePaydatesToArray($paydates);
	$data['paydates']=$pdr['rows'];
	$data['paydates_count']=$pdr['count'];

	$tfd_arr=scidTfeedetails($db,$sy,$scid,$num);		
	$data['tfeedetails']=$tfd_arr['rows'];		
	$data['tfeedetails_count']=$tfd_arr['count'];	
	

	return $data;
	
}	/* fxn */


function getPeriodFactor($qtr,$paymode_id){
	$period_factor=1;	
	
	if($paymode_id==2){
		if($qtr>2){ $period_factor=2; }	
	} else if($paymode_id==4){
		$period_factor=$qtr;
	} else if($paymode_id==3){
		$period_factor=$qtr*2;		
	}
		
	return $period_factor;
}

function hasNoBalance($total_payment,$required_payable,$allowance){
	$balance=$required_payable-($total_payment+$allowance);
	$allowed=($balance>0)? $balance:true;
	return $allowed;
}	/* fxn */


function hasBalance($total_payment,$required_payable,$allowance){
	$balance=$required_payable-($total_payment+$allowance);
	$has_balance=($balance>0)? $balance:false;
	return $has_balance;
}	/* fxn */


function isEmployeeChild($db,$sy,$scid){	
	$dbo=PDBO;
	$q="SELECT p.id AS pkid,p.sy,p.scid,ft.name AS feetype,p.amount
		FROM {$dbo}.30_payables AS p 
		INNER JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id=ft.id
		WHERE p.sy=$sy AND p.scid=$scid AND ft.code LIKE '%DISCEMP%'; ";	
	debug("enrollmentFxn-isEmployeeChild: $q");
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	debug($row);
	return (empty($row))? false:true;
}	/* fxn */


function canViewRcard($isEmployeeChild,$totalBalance,$allowance){
	// $hasNoBalance=(!$hasMinimumBalance && !$hasPreviousBalance && !$hasOtherBalance)? true:false;
	$hasNoBalance=(($totalBalance-$allowance)<=0)? true:false;
	$allowed=($isEmployeeChild || $hasNoBalance)? true:false;
	return $allowed;	
}	/* fxn */



function getTotalPaymentByFeetype($payments,$feetype_id){
	$total=0;
	foreach($payments AS $row){
		if($row['feetype_id']==$feetype_id){
			$total+=$row['amount'];
		}
	}
	return $total;
}	/* fxn */

function getOtherBalance($nondiscount_payables){
	$otherBalance=0;
	foreach($nondiscount_payables AS $row){
		$otherBalance+=$row['balance'];
	}
	return $otherBalance;
}	/* fxn */


function getStudentEnrollment($db,$sy,$scid,$student,$qtr,$period_factor,$arp,$payments,$allowance,$prevbal){
	// prx($sy);
	$enrollment['qtr']=&$qtr;
	$enrollment['paymode_id']=&$student['paymode_id'];
	$enrollment['student']=&$student;
	
	$enrollment['annuity']=$annuity=$arp['adjusted_periodic'];
	$enrollment['paid_tuition']=$paid_tuition=getTotalPaymentByFeetype($payments,1);
	$enrollment['paid_deposit']=$paid_deposit=getTotalPaymentByFeetype($payments,2);
	$enrollment['paid_prevbal']=$paid_prevbal=getTotalPaymentByFeetype($payments,3);
	$total_payment=$enrollment['paid_tuition']+$enrollment['paid_deposit'];
	$enrollment['total_paid_tuition']=&$total_payment;	
	$required_payable=$annuity*$period_factor;
	
	
	$enrollment['required_payable']=&$required_payable;
	$enrollment['allowance']=$allowance;	
	$enrollment['previous_balance']=$previous_balance=$student['previous_balance'];
	$enrollment['prevbal_left']=$prevbal_left=$prevbal-$paid_prevbal;
	$enrollment['minimum_balance']=$minimum_balance=$required_payable-$total_payment;	
	
	// pr($enrollment);
	// prx($enrollment);

	$isEmployeeChild=isEmployeeChild($db,$sy,$scid);	
	$enrollment['is_employee_child']=&$isEmployeeChild;
				
	$enrollment['tuition_balance']=$required_payable-$total_payment;	
	$enrollment['previous_balance']=$prevbal-$paid_prevbal;		
	$enrollment['other_balance']=0;	
	if($qtr>3){ 
		$nondiscount_payables = $student['nondiscounts'];	
		$enrollment['other_balance']=getOtherBalance($nondiscount_payables);		
	}
	
	$enrollment['hasOtherBalance']=$hasOtherBalance=($enrollment['other_balance']>0)? $enrollment['other_balance'] : false;
	
	$enrollment['hasMinimumBalance']=$hasMinimumBalance=hasBalance($total_payment,$required_payable,$allowance);			
	$enrollment['hasPreviousBalance']=$hasPreviousBalance=hasBalance($paid_prevbal,$prevbal,$allowance);			
	
	$enrollment['total_balance']=$enrollment['tuition_balance']+$enrollment['previous_balance']+$enrollment['other_balance'];
	
	// $can_view_rcard=canViewRcard($isEmployeeChild,$hasMinimumBalance,$hasPreviousBalance,$hasOtherBalance);
	// canViewRcard($isEmployeeChild,$totalBalance,$allowance)
	// echo "allowance: $allowance <br>";
	// echo "total_balance: ".$enrollment['total_balance']." <br>";
	
	$can_view_rcard=canViewRcard($isEmployeeChild,$enrollment['total_balance'],$allowance);
	$enrollment['can_view_rcard']=$can_view_rcard;

	// echo 'can view rcard: ';
	// echo ($can_view_rcard)? 'yes':'no';
	// echo '<br>';
	
	$enrollment['error_otherbal']=$error_otherbal=($hasOtherBalance)? "Other Balance: ".number_format($enrollment['other_balance'],2):false; 
	$enrollment['error_minbal']=$error_minbal=($hasMinimumBalance)? "Minimum Balance: ".number_format($enrollment['minimum_balance'],2):false; 
	$enrollment['error_prevbal']=$error_prevbal=($hasPreviousBalance)? "Previous Balance: ".number_format($prevbal_left,2):false; 

	// pr($enrollment['can_view_rcard']);
	// prx($enrollment['total_balance']);
	

	return $enrollment;
	
}	/* fxn */

 
function getTfeesFromPayables($db,$sy,$scid){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.30_payables WHERE sy=$sy AND scid=$scid AND feetype_id=1 ORDER BY ptr; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	return $data;
	
	
}	/* fxn */




function checkPreviousAccounts($db,$sy,$scid){
	$dbo=PDBO;
	$start_ensy=$_SESSION['settings']['year_start_enrollment'];
	
	$prevsy_balance=0;
	$prevsy=($sy-1);	
	$has_prevsy=($sy>$start_ensy)? true:false;
	
	if($has_prevsy){	
		$prevsy_payables=scidPayables($db,$prevsy,$scid,$fields=NULL);
		$prevsy_balance=summateAmount($prevsy_payables,'balance',$include_discounts=false);				
	}
	
	$data['has_prevsy_balance']=($prevsy_balance>0)? true:false;
	$data['prevsy_balance']=$prevsy_balance;
	$data['has_prevsy']=$has_prevsy;
	$data['prevsy']=$prevsy;
	
	return $data;	
	
}	/* fxn */

function getClassroomByStudent($db,$sy,$scid){
	$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT summ.crid AS nextcrid,cr.name AS nextclassroom
		FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE summ.scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
	
}	/* fxn */

