
<h5>Traits Matrix  
<span class="u" onclick="tracehd();" >HD</span> (<?php echo $cr['classroom']; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a class="u" id="btnExport" >Excel</a> 	

</h5>

<table class="gis-table-bordered hd" >
<tr><th>Crid#<?php echo $crid; ?></th><th>Crs#<?php echo $crs; ?></th>
<td><?php foreach($teachers AS $row){ echo $row['tcid'].'-'.$row['teacher'].' ('.$row['label'].') | '; } ?></td>
</tr>
</table>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
?>
<script>
	
function redirCtype(){
	var url = gurl+"/trs/matrix/"+crid+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val();	
	window.location = url;		
}	/* fxn */
	
</script>

<br />

<?php 	
	$numgrades=count($grades[0]);
	if($numteacs<>$numgrades){ echo '<h4 class="brown" >purge/trsTcid/$tcid</h4>'; }
	
?>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
<th>#</th>
<th>Student</th>
	<?php foreach($teachers AS $row): ?>
		<th>
			<span class="hd" ><?php echo $row['tcid']; ?><br /></span>
			<span class="vertical" ><?php echo $row['label']; ?></span></th>
	<?php endforeach; ?>
<th>Ave</th>	
</tr>

<tr>
	<td><?php echo 1; ?></td>
	<td><?php echo $students[0]['student']; ?></td>
	<?php $rows=$grades[0];$sum=0;$ave=0;	?>	
	<?php foreach($rows AS $row): ?>
		<?php $sum+=$row['ave']; ?>
		<td><span class="hd" ><?php echo $row['tcid']; ?><br /></span>
			<?php echo number_format($row['ave'],2); ?></td>
	<?php endforeach; ?>
	<td><?php $ave=$sum/$numteacs; echo number_format($ave,2); ?>
	| <?php $dg = rating($ave,$ratings); echo $dg; ?>			
	</td>
</tr>

<?php for($i=1;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<?php $rows=$grades[$i];$sum=0;$ave=0;	?>	
	<?php foreach($rows AS $row): ?>
		<?php $sum+=$row['ave']; ?>
		<td><?php echo number_format($row['ave'],2); ?></td>
	<?php endforeach; ?>
	
	<td><?php $ave=$sum/$numteacs; echo number_format($ave,2); ?>
	| <?php $dg = rating($ave,$ratings); echo $dg; ?>		
	
	</td>
</tr>
<?php endfor; ?>	<!-- count -->


</table>

<p><?php $this->shovel('filter_ctypes',$d); ?></p>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<script>

var gurl = 'http://<?php echo GURL; ?>';	
var crid = '<?php echo $crid; ?>';
var sy = '<?php echo $sy; ?>';
var qtr = '<?php echo $qtr; ?>';
var ds = '/';



$(function(){	
	excel();
	hd();	
	nextViaEnter();	  
	
});


</script>