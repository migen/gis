<div class="rmks " >
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