<?php

 

// pr($age_range);



function getAge($birthmonth,$birthyear,$sy){
	$age = $sy - $birthyear;
	
	switch($birthmonth){
		case ( $birthmonth < 4):
			$age += 0.5; break;		
		
		case ( $birthmonth > 9):
			$age -= 0.5; break;				
			
	}
	$age += 0.75;
	return number_format($age,2);
		
};
