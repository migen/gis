<?php 

// LSM rcard_vars

// $num_subjects 	= $_SESSION['settings']['num_subjects']+1;
$num_subjects 	= 16;

$num_legendtr 	= count($legendctr);
$num_legendcrs  = count($legendcrs);
$sem_numrows = 11;


$fullwidth="9in";

/* 1 */


$qtr_fg 	  = (4-1);
$qodd = ($qtr%2);
$level_shs = '13';  /* 14 is senior high school 1 */

$pagecolor = "black";
$pagewidth = "9.5in";

$subfont = "tf11";
$childfont = "tf10";
$blankfont = "tf12";
$promofont = "tf11";
$avefont = "tf12";
$legendfont = "tf10";
$headfont = "tf12 bold";
$headrowfont = "tf12";
$attheadrowfont = "tf10";


$logo_src = URL."public/images/weblogo_{$sch}.png";
$decietc = '2';
$decietcave = '3';
$logo_src = URL."public/images/weblogo_{$sch}.png";

$passing = $_SESSION['settings']['passing_grade'];
$rcardteac = $_SESSION['settings']['rcardteac'];
$deciatt = $_SESSION['settings']['deciatt'];
$deciave = $_SESSION['settings']['deciave'];
$deciave=($classroom['department_id']==3)? $_SESSION['settings']['deciave_hs']:$_SESSION['settings']['deciave_gs'];


$decicard = $_SESSION['settings']['decicard'];
$deciranks = $_SESSION['settings']['deciranks'];
$deciconducts = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];
$decigenave = $_SESSION['settings']['decigenave'];
$decifgenave = $_SESSION['settings']['decifgenave'];

$logo_src = URL."public/images/weblogo_{$sch}.png";
$paascu = "<span>PAASCU</span> <span class='i' >Accredited</span><br />";


$num_subjects = (isset($_GET['tpl']) && ($_GET['tpl']==1))? '10':$num_subjects;
$get_tpl = (isset($_GET['tpl']))? $_GET['tpl']:2;

switch($get_tpl){
	case 1: $num_subjects=10; break;
	default : $num_subjects; break;	
}	/* switch */


?>
