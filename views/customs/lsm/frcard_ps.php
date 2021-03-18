<?php 
	$rowlen="60";
	$numtr="6";
	$trsize="800px;";
	$signsize="180px;";
	$rowchars="100";
?>
<style>
 
 

@media print{@page{size:landscape}} 

div.frcardhalf{ float:left;width:48%;min-height:600px;font-size:1em; }
div.rmks{ min-height:140px;padding:10px 20px 20px 10px; }
.rh{ color:black;font-size:1.2em; }

</style>

<h5 class="screen" >
LSM Front

</h5>

<?php

for($i=0;$i<$num_students;$i++): 	/* start classlist */
	$student = $students[$i];
	ob_start();	

?>


<div class="clear frcardhalf" >	<!-- left -->

<div class="rmks bordered" >
<h4 class="center" >TEACHER'S REMARKS</h4>
<p class="rh" >Initial</p>
<table class="gis-table-bordered" >
<?php 
	$str=$student['initial'];
	$strlen=strlen($str); 
	$count=ceil($strlen/$rowlen);	
?>
<?php for($k=0;$k<$numtr;$k++): ?>
	<?php $offset=$k*$rowlen; ?>
	<tr><td><?php echo substr($str,$offset,$rowlen); ?>&nbsp;</td></tr>
<?php endfor; ?>
	<tr><th style="width:<?php echo $trsize; ?>" >&nbsp;</th></tr>		
</table>

<p class="rh" >Final</p>
<table class="gis-table-bordered" >
<?php 
	$str=$student['final'];
	$strlen=strlen($str); 
	$count=ceil($strlen/$rowlen);	
?>
<?php for($k=0;$k<$numtr;$k++): ?>
	<?php $offset=$k*$rowlen; ?>
	<tr><td><?php echo substr($str,$offset,$rowlen); ?>&nbsp;</td></tr>
<?php endfor; ?>		
	<tr><th style="width:<?php echo $trsize; ?>" >&nbsp;</th></tr>		
</table>
</div>

<p></p>

<div class="rmks bordered" >
<h5 class="center" >CERTIFICATE OF ELIGIBILITY</h5>
<table class="gis-table-bordered" >
	<tr><td colspan="" >The bearer 
		<span class="" ><?= $student['student']; ?></span></td></tr>	
	<tr><td colspan="" >is eligible for transfer and admission to </td></tr>		
	<tr><th colspan="" style="width:<?php echo $trsize; ?>" >&nbsp;</th></tr>		

</table>
<br />
<table class="xgis-table-bordered" >	
<tr>
	<th>____________________________</th>
	<th></th><th>____________________________</th>
</tr>
<tr>
	<td style="width:<?php echo $signsize; ?>" >Parent's Signature:</td>
	<td class="vc100" >&nbsp;</td>
	<td style="width:<?php echo $signsize; ?>"  >ANA EVA G. BOLINAO
		<br />Grade School Principal
	</td>
</tr>	
</table>
</div>


</div>	<!-- frcardhalf left -->


<div style="width:2%;float:left;min-height:500px;" >&nbsp;</div>


<div class="frcardhalf bordered center" >

<?php 
	include('incs/frcard_right.php');
?>
</div>


<p class="pagebreak" >&nbsp;</p>


<?php
	
	$ob = "ob$i";
	$$ob = ob_get_clean();
	ob_flush();
?>	
	
<?php endfor; ?>		<!-- end classlist -->


<!-- print output below -->

<?php

for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;

}	

 
?>
