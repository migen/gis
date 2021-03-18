<?php

$midfix="";		// a
// require_once(SITE."views/customs/".VCFOLDER."/credits_fixed.php");		/* credentials */
require_once(SITE."config/customs/credits_fixed_".VCFOLDER.".php");		/* credentials */
DEFINE("DBM","dbgis".$midfix.US.VCFOLDER);						
DEFINE("DBG","dbgis".$midfix.US.VCFOLDER);						
DEFINE("DBO",VCPREFIX."dbone".$midfix.US.VCFOLDER);					
DEFINE("DBP",VCPREFIX."dbpix".$midfix.US.VCFOLDER);						


/* ------------------------ DB Config ------------------------------------------------------------ */

/* old 192.168.0.5 */
if(IS_LOCAL){
	DEFINE('DBTYPE','mysql');
	DEFINE('DBHOST','localhost');
	DEFINE('DBUSER','root');
	DEFINE('DBPASS','');	
} else {
	DEFINE('DBTYPE','mysql');
	DEFINE('DBHOST','192.168.1.251'); 
	DEFINE('DBSUBMASK','255.255.255.0'); 
	DEFINE('DBUSER','root');
	DEFINE('DBPASS','Gisdbpass#88');	
}



