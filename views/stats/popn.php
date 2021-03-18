<?php 
	if(isset($_GET['debug'])){ pr($dq); }
?>

<h5>	
	<span ondblclick="tracehd();" class="u" >HD</span> 	
	Enrollees SY<?php echo $sy." - ".($sy+1); ?>

</h5>


<table class="gis-table-bordered" >
<tr><th>School</th><td class="vc120" ><?php echo strtoupper(VCFOLDER); ?></td></tr>
<tr><th>Total</th><td><?php echo $summer; ?></td></tr>


</table>

<br /><br />

<table class="gis-table-bordered table-altrow" >
<tr><th colspan=3 >Paid</th></tr>
<tr><th>#</th><th class="vc100" >Level</th><th class="vc50" >Tally</th></tr>
<?php 
$total=0; for($i=0;$i<$count;$i++): $total+=$rows[$i]['count'];

?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td class="right" ><?php echo $rows[$i]['count']; ?></td>
</tr>
<?php endfor; ?>
<tr>
<th colspan="2" >Total</th>
<th class="right" ><?php echo $total; ?></th>
</tr>
<?php $num_paid=$total; ?>

</table>

<br /><br />

<table class="gis-table-bordered table-altrow" >
<tr><th colspan=3 >Free</th></tr>
<tr><th>#</th><th class="vc100" >Level</th><th class="vc50" >Tally</th></tr>
<?php 
$total=0; for($i=0;$i<$freecount;$i++): $total+=$freerows[$i]['count'];
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $freerows[$i]['level']; ?></td>
	<td class="right" ><?php echo $freerows[$i]['count']; ?></td>
</tr>
<?php endfor; ?>
<tr>
<th colspan="2" >Total</th>
<th class="right" ><?php echo $total; ?></th>
</tr>
<?php $num_free=$total; ?>
<?php $num_total=$num_paid+$num_free; ?>
</table>


<h5>Total Students: <?php echo $num_paid." + ".$num_free." = "; echo $num_total; ?></h5>

<div class="hd" >
<p>&nbsp;</p>
Q1: <?php pr($q1); ?>
Q2: <?php pr($q2); ?>
Q3: <?php pr($q3); ?>

<table class="gis-table-bordered" >
<tr><th>Wrong Total</th><td><?php echo $wrong; ?></td></tr>
</table>
</div>

<div class="ht100" ></div>

<script>

$(function(){
	hd();
})



</script>
