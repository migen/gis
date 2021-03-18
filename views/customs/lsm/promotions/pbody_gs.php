

<?php 
// pr($students[1]);

$ltw="610px";	/* left table width */
$rtw="280px";	/* right table width */
$honors_cutoff='94';

?>

<div style="float:left;width:65%" class="unbordered" >
<table id="tblExport" class="gis-table-bordered-print table-fx tf12 " style="width:<?php echo $ltw; ?>;" >
<thead>
<tr class="" >
	<th rowspan="2" >LRN</th>
	<th rowspan="2" >NAMES <br />
		(Surnames First, listed alphabetically)
	</th>
	<th rowspan="2" class="vc50" >GENERAL<br />AVERAGE<br />(Whole numbers for non-honor)</th>	
	<th rowspan="2" class="vc80" >ACTION<br />TAKEN</th>	
	<th rowspan="2" style="width:190px;"  >Did not meet Expectations of the ff. Learnng Area/s as of end of Current 
	School Year</th>	
</tr>
</thead>

<tbody>
<?php for($t=0;$t<$numstud;$t++): ?>
<tr>
	<td style="min-width:110px;" ><?php echo $students[$t]['lrn']; ?></td>
	<td class="pdl05" style="width:240px;" ><?php echo $students[$t]['student']; ?></td>
	<td><?php $fgenave  = $students[$t]['ave_q5']; 
		$fgenave=($fgenave<$honors_cutoff)? round($fgenave):number_format($fgenave,2);
		echo $fgenave ?></td>	
	<td><?php if($students[$t]['is_promoted']==1){ echo 'Promoted'; } 
		elseif($students[$t]['is_promoted']==0){ echo 'Retained'; } 
		else{ echo 'Conditional'; }; ?></td>	
	<td><?php echo $students[$t]['incsubj']; ?></td>	

</tr>
<?php endfor; ?>

<tr><td></td><td>&nbsp; </td><td></td><td></td><td></td></tr>
<tr><td></td><td>&nbsp; </td><td></td><td></td><td></td></tr>
<tr><td></td><td>&nbsp; </td><td></td><td></td><td></td></tr>

<tr><td></td><td><?php echo $prep['count_boys']; ?> TOTAL MALE</td><td></td><td></td><td></td></tr>
<tr><td></td><td><?php echo $prep['count_girls']; ?> TOTAL FEMALE</td><td></td><td></td><td></td></tr>
<tr><td></td><td><?php echo $prep['count_total']; ?> TOTAL COMBINED</td><td></td><td></td><td></td></tr>
</tbody>

</table>
</div>	<!-- pbody left -->


<div style="float:left;width:30%" >
<div style="height:30px;" ></div>

<?php 
	$cw='140px'; 
	$tw='30px';	
	include_once('pform.php');
?>



<!-- signatures -->
<br />
<table class="nogis-table-bordered" style="font-size:0.7em;text-align:center;width:<?php echo $rtw; ?>;" >
<tr><td>PREPARED BY:<br /><br />
</td></tr>
<tr class="center" ><td><?php echo $classroom['adviser']; ?></td></tr>
<tr class="center" ><td><hr /></td></tr>
<tr class="center" ><td>Class Adviser</td></tr>
<tr class="center" ><td>(Name and Signature)</td></tr>

<tr><td>CERTIFIED CORRECT & SUBMITTED: <br /><br />
</td></tr>
<tr class="center" ><td><?php echo $_SESSION['settings']['school_principal_gs']; ?></td></tr>
<tr class="center" ><td><hr /></td></tr>
<tr class="center" ><td>School Head</td></tr>
<tr class="center" ><td>(Name and Signature)</td></tr>

<tr><td>REVIEWED BY: <br /><br />
</td></tr>
<tr class="center" ><td><?php echo ''; ?></td></tr>
<tr class="center" ><td><hr /></td></tr>
<tr class="center" ><td>Division Representative</td></tr>
<tr class="center" ><td>(Name and Signature)</td></tr>
</table>


<!-- guidelines -->

<table class="nogis-table-bordered" style="font-size:0.7em;text-align:center;width:<?php echo $rtw; ?>;" >
<tr><th>GUIDELINES:</th></tr>
<tr><td>1. Do not include Dropouts and Transferred Out (D.O.4,2014)</td></tr>
<tr><td>2. To be prepared by the Adviser. The Adviser should indicate the General Average based on the learner's Form 138.</td></tr>


<tr><td>3. On the summary table, reflect the total number of learners PROMOTED (Final Grade of at least 75 in ALL learning areas), RETAINED (Did Not Meet Expectations in three (3) or more learning areas) and *Conditional (*Did Not Meet Expectations in not more than two (2) learning areas) and the Learning Progress and Achievement according to the individual General Average. All provisions on classroom assessment and the grading system in the said Order shall be in effect for all grade levels - Deped Order 29,s.2015. </td></tr>

<tr><td>4. Did Not Meet Expectations of the Learning Areas. This refers to learning area/s that the learner had failed as of end of current SY. The learner may be for remediation or retention. </td></tr>


<tr><td>5. Protocols of validation & submission is under the discretion of the Schools Division Superintendent.</td></tr>

<tr  ><td class="right" >School Form 5: Page ___ of ____</td></tr>
<tr><td>&nbsp; </td></tr>


</table>


</div>	<!-- pbody right -->


