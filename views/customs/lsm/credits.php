<?php

$midfix="";		// a
// require_once(SITE."views/customs/".VCFOLDER."/credits_fixed.php");		/* credentials */
require_once(SITE."config/customs/credits_fixed_".VCFOLDER.".php");		/* credentials */
DEFINE("DBG","dbgis".$midfix.US.VCFOLDER);						
DEFINE("DBO",VCPREFIX."dbone".$midfix.US.VCFOLDER);					
DEFINE("DBP",VCPREFIX."dbpix".$midfix.US.VCFOLDER);						
DEFINE("PDBG",VCPREFIX.DBYR.US."dbgis".$midfix.US.VCFOLDER);						
DEFINE("PDBO",VCPREFIX."dbone".$midfix."_".VCFOLDER);						
DEFINE("PDBP",VCPREFIX."dbpix".$midfix."_".VCFOLDER);						


/* --- DB Config --- */

// DEFINE('DBTYPE','mysql');
// DEFINE('DBHOST','192.168.1.251');
// DEFINE('DBUSER','lsm1606');
// DEFINE('DBPASS','Lsm#1606');

DEFINE('DBTYPE','mysql');
DEFINE('DBHOST','localhost');
DEFINE('DBUSER','root');
DEFINE('DBPASS','');
// DEFINE('DBPASS','');
