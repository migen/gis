

<table style="font-size:1em;width:<?php echo $ftw; ?>;" class="no-gis-table-bordered center" >	
	<tr><td class="b" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

<?php 

// echo "both $both <br />";


if($both){
	$grades=$ones;
	$blank=false;
	$sem=1;
	$qodd = ($qtr>2)? false:($qtr%2);
	$numacad=count($ones);
	include(SITE."views/customs/{$sch}/rptincs/srgrades_table.php");

	echo "<br />";
	$sem=2;
	$qodd = ($qtr%2);
	$blank = ($qtr<3)? true:false;
	$grades=$twos;
	$numacad=count($twos);	
	include(SITE."views/customs/{$sch}/rptincs/srgrades_table.php");
} else {
	// pr($grsem);
	$grades=$$grsem;
	$blank=false;
	$sem=$sem;
	$qodd = ($qtr>2)? false:($qtr%2);
	$numacad=count($grades);		
	include(SITE."views/customs/{$sch}/rptincs/srgrades_table.php");


}


?>
