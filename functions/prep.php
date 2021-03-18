<?php


function updatePromOld($db,$dbg,$promotions,$prevcrid,$next_year){
	$dbo=PDBO;
	$this_year = $next_year - 1;
	$grad_level = $_SESSION['settings']['graduate_level'];

	$q = "";	
	foreach($promotions AS $row){		
		$q .= "		
			UPDATE {$dbg}.05_students AS s 
			SET 
				s.`years_in_school`		= '".$row['years_in_school']."',
				s.`units_previous`		= '".$row['units_previous']."',
				s.`units_current`		= '".$row['units_current']."',
				s.`units_total`			= '".$row['units_total']."' 				
			WHERE s.contact_id 			= '".$row['scid']."' LIMIT 1;				
		";	
		$q .= " UPDATE {$dbo}.`00_profiles` SET `age` = '".$row['age']."' WHERE `contact_id` = '".$row['scid']."' LIMIT 1; ";
		/* 1-B - set c.is_active = 0 if cr.level_id is graduate level from settings */

		
	}	/* foreach */		
	$db->query($q);
	  
}	/* fxn */


function updateProm($db,$dbg,$promotions,$currlvl,$currcrid,$next_year){
	$dbo=PDBO;
	$this_year  = $next_year - 1;
	$grad_level = $_SESSION['settings']['graduate_level'];

	$q = "";	
	foreach($promotions AS $row){	
		$incsubj = $row['incsubj'];
		$q .= " UPDATE {$dbg}.05_summaries AS summ SET  		
					summ.`incunits`='".$row['incunits']."',summ.`incsubj`='$incsubj',
					summ.`is_promoted`='".$row['is_promoted']."',summ.`eligdate`='".$row['eligdate']."',
					summ.`promlvl`='".$row['promlvl']."',summ.`currlvl`='$currlvl',
					summ.`currcrid`='$currcrid',summ.`promcrid`='".$row['crid']."'
				WHERE summ.`scid`='".$row['scid']."' LIMIT 1; ";						
	}	/* foreach */		
	// pr($q);exit;	
	$db->query($q);
		 
 
}	/* fxn */


/* for promotions,by adviser */
function updatePrepOld($db,$dbg,$prep,$crid,$sy){
	$dbo=PDBO;
	/* now update 1 row in promotions table */
	$today = $_SESSION['today'];
	$q = "UPDATE {$dbg}.05_promotions SET 
			modified_date='".$today."',			
			count_boys='".$prep['count_boys']."',
			count_girls='".$prep['count_girls']."',
			count_total='".$prep['count_total']."',			
			count_promoted_boys='".$prep['count_promoted_boys']."',			
			count_promoted_girls='".$prep['count_promoted_girls']."',
			count_promoted_total='".$prep['count_promoted_total']."',					
			sum_age_boys='".$prep['sum_age_boys']."',
			sum_age_girls='".$prep['sum_age_girls']."',
			sum_age_total='".$prep['sum_age_total']."',
			sum_age_promoted_boys='".$prep['sum_age_promoted_boys']."',
			sum_age_promoted_girls='".$prep['sum_age_promoted_girls']."',
			sum_age_promoted_total='".$prep['sum_age_promoted_total']."',
			ave_age_boys='".$prep['ave_age_boys']."',
			ave_age_girls='".$prep['ave_age_girls']."',
			ave_age_total='".$prep['ave_age_total']."',
			ave_age_promoted_boys ='".$prep['ave_age_promoted_boys']."',
			ave_age_promoted_girls='".$prep['ave_age_promoted_girls']."',
			ave_age_promoted_total='".$prep['ave_age_promoted_total']."'						
		WHERE `crid` = '".$crid."' ; ";	
	$db->query($q);

}	/* fxn */



/* for promotions,by adviser */
function updatePrep($db,$dbg,$prep,$crid,$sy){
	$dbo=PDBO;
	/* now update 1 row in promotions table */
	$today = $_SESSION['today'];
	$q="UPDATE {$dbg}.05_promotions SET 
			modified_date='".$today."',
			count_boys='".$prep['count_boys']."',
			count_girls='".$prep['count_girls']."',
			count_total='".$prep['count_total']."',
			count_promoted_boys='".$prep['count_promoted_boys']."',			
			count_promoted_girls='".$prep['count_promoted_girls']."',
			count_promoted_total='".$prep['count_promoted_total']."',			
			count_conditional_boys='".$prep['count_conditional_boys']."',			
			count_conditional_girls='".$prep['count_conditional_girls']."',
			count_conditional_total='".$prep['count_conditional_total']."',						
			count_retained_boys='".$prep['count_retained_boys']."',
			count_retained_girls='".$prep['count_retained_girls']."',
			count_retained_total='".$prep['count_retained_total']."',						
			count_irregular_boys='".$prep['count_irregular_boys']."',
			count_irregular_girls='".$prep['count_irregular_girls']."',
			count_irregular_total='".$prep['count_irregular_total']."',			
			count_genave_boys_A='".$prep['count_genave_boys_A']."',
			count_genave_girls_A='".$prep['count_genave_girls_A']."',
			count_genave_total_A='".$prep['count_genave_total_A']."',
			count_genave_boys_P='".$prep['count_genave_boys_P']."',
			count_genave_girls_P='".$prep['count_genave_girls_P']."',
			count_genave_total_P='".$prep['count_genave_total_P']."',
			count_genave_boys_AP='".$prep['count_genave_boys_AP']."',
			count_genave_girls_AP='".$prep['count_genave_girls_AP']."',
			count_genave_total_AP='".$prep['count_genave_total_AP']."',
			count_genave_boys_D='".$prep['count_genave_boys_D']."',
			count_genave_girls_D='".$prep['count_genave_girls_D']."',
			count_genave_total_D='".$prep['count_genave_total_D']."',
			count_genave_boys_B='".$prep['count_genave_boys_B']."',
			count_genave_girls_B='".$prep['count_genave_girls_B']."',
			count_genave_total_B='".$prep['count_genave_total_B']."' 						
		WHERE `crid` = '".$crid."' ;";	
	$db->query($q);

}	/* fxn */



