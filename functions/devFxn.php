<?php


function getDummyRcardData($name,$grade=1,$is_promoted=true){
	
	$data['student']=array(
		'id'=>1001,
		'name'=>$name,
		'lrn'=>'53543435',
		'code'=>'20182531',
		'level'=>'Grade '.$grade,
		'is_promoted'=>$is_promoted,
		'level_promoted'=>'Grade '.($grade+1),
		
		
	);
	
	$data['averages']=array(
		'q1_ave'=>91,
		'q2_ave'=>88,
		'q3_ave'=>88,
		'q4_ave'=>88,
		'final_ave'=>88,
	);
	
	$data['grades']=array(
		array(
			'subject'=>'English',
			'q1'=>91,'q2'=>92,'q3'=>93,'q4'=>94,'q5'=>93,			
		),
		array(
			'subject'=>'Computer',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),		
		array(
			'subject'=>'Mathematics',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),		
		array(
			'subject'=>'Christian Living',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),		
		array(
			'subject'=>'Araling Panlipunan',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),		
		array(
			'subject'=>'Science',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),		
		array(
			'subject'=>'Music',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),		
		array(
			'subject'=>'Arts',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),		
		array(
			'subject'=>'Physical Education',
			'q1'=>91,'q2'=>82,'q3'=>93,'q4'=>74,'q5'=>88,			
		),				
		
	);
	
	
	$data['attendance']=array(
		'jun_days_present'=>12,
		'jul_days_present'=>25,
		'aug_days_present'=>22,			
		'sep_days_present'=>12,
		'oct_days_present'=>25,
		'nov_days_present'=>22,			
		'dec_days_present'=>12,
		'jan_days_present'=>25,
		'feb_days_present'=>22,			
		'mar_days_present'=>22,			
		'jun_days_tardy'=>0,
		'jul_days_tardy'=>1,
		'aug_days_tardy'=>2,			
		'sep_days_tardy'=>12,
		'oct_days_tardy'=>25,
		'nov_days_tardy'=>22,					
		'dec_days_tardy'=>12,
		'jan_days_tardy'=>25,
		'feb_days_tardy'=>22,			
		'mar_days_tardy'=>22,	
	);
		
	
	return $data;
	
	
}


function getMonths(){
	$data=array(
		'jun','jul','aug',
		'sep','oct','nov',
		'dec','jan','feb','mar'
	);
	return $data;
	
}
