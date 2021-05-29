<?php

// echo "enrollment sjam included ";

function getPayableBalanceProd($payable,$payments){
	$row['paid']=0;
	$row['balance']=$payable['amount'];
	foreach($payments AS $payment){
		if(($payable['feetype_id']==$payment['feetype_id']) && ($payable['ptr']==$payment['ptr'])){
			$row['paid']+=$payment['amount'];		
		}		
	}
	$row['balance']-=$row['paid'];
	prx($row);
	return $row;
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



function getPayplansSjam($total,$lvl,$num=1){	
	$row['yearly']=$total;	
	$row['semestral']=$total*1.05/2;	
	$row['quarterly']=$total*1.075/4;
	if($lvl>2){
		$row['monthly']=$total*1.375/10;
	} else {
		$row['monthly']=$total/8;		
	}	
	/* jhs and ec */
	if(($lvl>9 && $lvl<14) && $num==2){
		$row['monthly']=$total/8;		
	}

	if($lvl==13 && $num==3){
		$row['monthly']=$total/8;		
	}

	
	return $row;
	
}	/* fxn */


function adjustPayablesSjam($student){
	extract($student);	
	switch($paymode_id){
		case 1:
			$adjusted=$total-$total_discount;
			$adjusted_periodic=&$adjusted;				
			$total_adjusted_amount=$adjusted_periodic*1;
			return array('adjusted_periodic'=>$adjusted_periodic,
				'initial_periodic'=>$total,'interest'=>0,'period'=>1,
				'total_adjusted_amount'=>$total_adjusted_amount);break;
		case 2:			
			$interest=$total*0.05;
			$interest=number_format($interest,2,'.','');

			$charged=$total*1.05;
			$adjusted=$charged-$total_discount;
			$adjusted_periodic=($adjusted/2);
			$adjusted_periodic=number_format($adjusted_periodic,2,'.','');
			
			$initial_periodic=$charged/2;
			$initial_periodic=number_format($initial_periodic,2,'.','');
			$total_adjusted_amount=$adjusted_periodic*2;
			
			return array('adjusted_periodic'=>$adjusted_periodic,'initial_periodic'=>$initial_periodic,
				'interest'=>$interest,'period'=>2,'total_adjusted_amount'=>$total_adjusted_amount);break;
		case 3:
			$interest=$total*0.1;
			$interest=number_format($interest,2,'.','');

			$a=$total*1.375;
			$b=$a/10;
			$c=$b*8;
			$d=$c-$total_discount;
			$adjusted_periodic=$d/8;					
			$adjusted_periodic=number_format($adjusted_periodic,2,'.','');
			
			$initial_periodic=$a/10;
			$initial_periodic=number_format($initial_periodic,2,'.','');

			$total_adjusted_amount=$adjusted_periodic*8;			
			return array('adjusted_periodic'=>$adjusted_periodic,'initial_periodic'=>$initial_periodic,
				'interest'=>$interest,'period'=>8,
				'total_adjusted_amount'=>$total_adjusted_amount);break;
		default:			
			$interest=$total*0.075;
			$interest=number_format($interest,2,'.','');

			$charged=$total*1.075;
			$adjusted=$charged-$total_discount;
			$adjusted_periodic=$adjusted/4;	
			$adjusted_periodic=number_format($adjusted_periodic,2,'.','');

			$initial_periodic=$charged/4;
			$initial_periodic=number_format($initial_periodic,2,'.','');

			$total_adjusted_amount=$adjusted_periodic*4;						
			$retval=array('adjusted_periodic'=>$adjusted_periodic,'initial_periodic'=>$initial_periodic,
			'interest'=>$interest,'period'=>4,
			'total_adjusted_amount'=>$total_adjusted_amount);
			return $retval;			
			break;				
			
	}
	
	
	
}	/* fxn */




