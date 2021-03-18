<h5>
	Enrollment Payment Report (EPR) SY<?php echo $sy; ?>
	<?php echo (isset($count))? '('.$count.')':NULL; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <span onclick="traceshd();" class="u" >SHD</span>
	| <a href="<?php echo URL.'enrollment/report'; ?>" />Filter</a>  
	| <a class="u" id="btnExport" >Excel</a> 
	
	
</h5>


<?php 
// pr($data);
// pr($q);
// pr($rows[0]);

?>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<?php if(isset($count) && ($count==0)){ echo "<h5>No results found. </h5>"; } ?>

<?php if(isset($count) && ($count>0)): ?>


<h4>From <?php echo $_GET['beg'].' To '.$_GET['end']; ?></h4>

<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th class="shd" >SY</th>	
	<th class="" >Scid</th>
	<th>ID No.</th>
	<th>Paymode</th>
	<th>Level</th>
	<th>Section</th>
	<th>Student</th>
	<th>Tuition<br />Payment<br />Date</th>
	<th>OR No</th>
	<th>Amount</th>	
	<th>Status</th>	
<?php if($_GET['parents']==1): ?>
	<th>Father</th>	
	<th>Mother</th>	
<?php endif; ?>	
	
</tr>


<?php 
	$total=$count;
	$old=0;
	$new=0;

?>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$scid=$rows[$i]['scid'];
	($rows[$i]['sy']==$ensy)? $new++:$old++;
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><a href="<?php echo URL.'contacts/sy/'.$scid; ?>" ><?php echo $rows[$i]['sy']; ?></a></td>
	<td class="" ><?php echo $scid; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo ucfirst($rows[$i]['paymode']); ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['orno']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo ($rows[$i]['sy']==$sy)? 'New':'Old'; ?></td>
<?php if($_GET['parents']==1): ?>
	<td><?php echo $rows[$i]['father']; ?></td>
	<td><?php echo $rows[$i]['mother']; ?></td>
<?php endif; ?>	
	
</tr>
<?php endfor; ?>
</table>
<br />

<table class="gis-table-bordered" >
	<tr><th>New Students</th><td><?php echo $new; ?></td></tr>
	<tr><th>Old Students</th><td><?php echo $old; ?></td></tr>
	<tr><th>Total</th><td><?php echo $count; ?></td></tr>
</table>


<?php else: ?>
<?php $incs="incs/enrpt_filter.php";include_once($incs); ?>

<?php endif; ?>


<script>

var hdpass 	= "<?php echo HDPASS; ?>";

$(function(){
	hd();
	shd();
	excel();
	$('#hdpdiv').hide();
	

})


</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



