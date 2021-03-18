<style>

.underline{ text-decoration:underline; }
.message{ color:brown; }

</style>
<?php




function checkDbyr($db,$sy){	
	$dbg=VCPREFIX.$sy.US.DBG;		
	$q="SELECT id FROM {$dbg}.`05_classrooms` WHERE `section_id`=1 LIMIT 1; ";
	
	$sth=$db->query($q);
	if($sth===false){
		pr("<h3 class='message' >DB <span class='underline'>*$sy</span> NOT setup yet. Contact MIS please. </h3>"); 
		return false;	
	} else {
		return true;
	}

	
			
}	/* fxn */

/* $rv = mysql_query("INSERT INTO redirects SET ua_string = '$ua_string'");
if ( $rv === false ){
     handle the error here
} */
