<style>


.trleft th, .trleft td{ text-align:left; } td.tdhleft,th.tdhleft{text-align:left; }

.tbp th, .tbp td  { padding:<?php echo $vpo.' '.$hpo; ?> ; color:<?php echo $color; ?>;}

.tbl-print { border: 1px solid #000; border-left: 0; border-top: 0; }
.tbl-print th, .tbl-print td  { border-left: 1px solid #000; 
	border-top: 1px solid #000; color:;}
.tbl-print th {color:#181818; }
.tbl-print th:first-child, .tbl-print td:first-child { color:; padding-left:6px; }

.gis-table-bordered-print th, .gis-table-bordered-print td { border:1px solid #000;}
.gis-table-bordered-attd th, .gis-table-bordered-attd td { border:1px solid #000;}

@media print{@page {size: portrait;}}
table.vc700{width:600px;}
.vc180{width:180px;}

.vcid{ width:110px;}
	
div.card{ margin-right:20px; }
table{ table-layout: fixed; } 
	

hr.broken{ background-color:#fff;border:#000 3px dotted;border-style: none none dotted;color:#fff;width:100%; }
div#cutout{}

	
</style>


<?php 

$num_subjects = ($_SESSION['settings']['num_subjects']+1);
$qtr_fg 	  = (4-1);

$tblwidth = "vc700";
$tblsubwidth = "vc500";
$subwidth = "vc200";
$subfont = "tf16";
$childfont = "tf16";
$blankfont = "tf16";
$legendfont = "tf14";
$attfont = "tf16";
$headrowfont = "tf16";
$attheadrowfont = "tf14";
$docfont = "tf14";
$headerfont = "tf18";
$headfont = "tf16";
$footfont = "tf12";
$subw = "vc200";


$logo_src = URL."public/images/weblogo_{$sch}.png";
$nsy = $sy+1;


$passing        = $_SESSION['settings']['passing_grade'];
$rcardteac      = $_SESSION['settings']['rcardteac'];
$deciatt    	= $_SESSION['settings']['deciatt'];
$decifg    	    = $_SESSION['settings']['decifg'];
$decicard       = $_SESSION['settings']['decicard'];
$deciranks      = $_SESSION['settings']['deciranks'];
$deciconducts   = $_SESSION['settings']['deciconducts'];
$decifconducts  = $_SESSION['settings']['decifconducts'];
$deciave     = $_SESSION['settings']['deciave'];
$decigenave     = $_SESSION['settings']['decigenave'];
$decifgenave    = $_SESSION['settings']['decifgenave'];




?>
