<?php 
	$divht="5.6in";
	$vspacer="0.2in";	/* vertical spacer */
	$rowlen="80";
	$numtr="6";
	$trsize="800px;";
	$signsize="180px;";
	$rowchars="100";
?>
<style>

div{border:1px solid white;}
div#content{border:1px solid white;}

 
@media print{@page{size:landscape}} 

div.frcardhalf{ float:left;width:48%;font-size:1em; }
div.rmks{ padding:10px 20px 20px 10px; }
.rh{ color:black;font-size:1.2em; }

</style>


<?php 

include_once('rptincs/menu_ps.php');


for($i=0;$i<$num_students;$i++): 	/* start classlist */
	$student = $students[$i];
	ob_start();	

?>

<div class="" style="height:<?php echo $vspacer; ?>;" ></div>

<div class="clear bordered frcardhalf" style="height:<?php echo $divht; ?>;position:relative;" >	<!-- left -->
<?php 
	include('rptincs/remarks_div.php');
	echo "<p></p>";
	include('rptincs/eligibility_fprcard.php');
	
?>
</div>	<!-- left -->


<div style="width:2%;float:left;min-height:4in;" >&nbsp;</div>


<div class="frcardhalf bordered center" style="height:<?php echo $divht; ?>;" >
<?php include('rptincs/fprcard_right.php'); ?>
</div>


<div class="clear" style="height:1in;" ></div>

<p class="pagebreak" >&nbsp;</p>


<?php
	
$ob = "ob$i";
$$ob = ob_get_clean();
ob_flush();
endfor; 	/* loop students */

for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;

}	

 
?>
