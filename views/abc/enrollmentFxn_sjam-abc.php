<?php

// echo "enrollment sjam included ";

function updatePayableBalance($db,$payable,$payments){
	$row['paid']=0;
	$row['balance']=$payable['amount'];
	foreach($payments AS $payment){
		if(($payable['feetype_id']==$payment['feetype_id']) && ($payable['ptr']==$payment['ptr'])){
			$row['paid']+=$payment['amount'];		
		}		
	}
	$row['balance']-=$row['paid'];
	return $row;
}	/* fxn */




function parsePayables($payables){
	$data['discounts']=array();
	$data['nondiscounts']=array();
	$data['total_discount']=0;
	$data['total_nondiscount']=0;
	foreach($payables AS $row){
		if($row['feetype_id']==3) continue;
		if($row['is_discount']==1){
			$data['total_discount']+=$row['amount'];
			array_push($data['discounts'],$row);
		} else {
			$data['total_nondiscount']+=$row['amount'];
			array_push($data['nondiscounts'],$row);			
		}
	}
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


function getResfee($payments){
	$resfee=0;
	foreach($payments AS $row){
		if($row['feetype_id']==2){
			$resfee+=$row['amount'];
		}		
	}
	return $resfee;
}	/* fxn */



function getPayplansSjam($total,$lvl){	
	$row['yearly']=$total;	
	$row['semestral']=$total*1.05/2;	
	$row['quarterly']=$total*1.075/4;
	if($lvl>2){
		$row['monthly']=$total*1.375/10;
	} else {
		$row['monthly']=$total/8;		
	}	
	return $row;
	
}	/* fxn */


function adjustPayablesSjam($student){
	pr($student);
	extract($student);	
	switch($paymode_id){
		case 1:
			$adjusted=$total-$total_discount;
			$adjusted_periodic=&$adjusted;				
			return array('adjusted_periodic'=>$adjusted_periodic,'initial_periodic'=>$total,'interest'=>0);break;
		case 2:			
			$interest=$total*0.05;
			$charged=$total*1.05;
			$adjusted=$charged-$total_discount;
			$adjusted_periodic=$adjusted/2;
			
			return array('adjusted_periodic'=>$adjusted_periodic,'initial_periodic'=>$charged/2,'interest'=>$interest);break;
		case 3:
			$interest=$total*0.1;
			$a=$total*1.375;
			$b=$a/10;
			$c=$b*8;
			$d=$c-$total_discount;
			$adjusted_periodic=$d/8;					
			// pr("adjusted_periodic : $adjusted_periodic");			
			return array('adjusted_periodic'=>$adjusted_periodic,'initial_periodic'=>$a/10,'interest'=>$interest);break;
		default:			
			$interest=$total*0.075;
			$charged=$total*1.075;
			$adjusted=$charged-$total_discount;
			$adjusted_periodic=$adjusted/4;	
			// pr("int_charged: $charged");
			// pr("less discount: $adjusted");			
			// pr("adjusted_periodic : $adjusted_periodic");
						
			return array('adjusted_periodic'=>$adjusted_periodic,'initial_periodic'=>$charged/4,'interest'=>$interest);break;				
	}
	
}	/* fxn */




