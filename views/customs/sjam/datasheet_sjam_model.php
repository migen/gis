<?php

if($scid){	


	// $contact=fetchRow($db,"{$dbcontacts}",$scid,"id,code,name");
	// $profile=fetchRecord($db,"{$dbprofiles}","contact_id=$scid","first_name,last_name");
	// pr($contact);
	// prx($profile);

	$contact=fetchRow($db,"{$dbcontacts}",$scid);
	$profile=fetchRecord($db,"{$dbprofiles}","contact_id=$scid");
	
	
	if(empty($profile)){ 
		$profile=array('contact_id'=>$scid);$db->add("{$dbo}.00_profiles",$profile);
		flashRedirect("students/datasheet/$scid","Synced profile.");
	}
		
	// $names='first_name','middle_name','last_name',	
	$except="'id','contact_id','profile_finalized','birthdate','is_male',";	
	$except.="'is_scholar_pta','is_scholar_academic','is_employee_child','is_grantee_fape',";
	$except.="'address','siblings_info','other_info','remarks'";
	
	
	$dr=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except);		
	$profiles_cols=$dr['field_array'];
	$profiles_field_str=$dr['field_string'];
	$profiles_count=$dr['count'];
	
	$constants=array('last_name','first_name','middle_name');
	$constants=&$constants;

	$skip_array=array('id','contact_id','profile_finalized');
	$text_array=array('address','siblings_info','other_info','remarks');


	extract($contact);
	extract($profile);
}	/* scid */
