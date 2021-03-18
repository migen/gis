<script>

$(function(){
	shd();
	excel();
})

function clearLvl(){ $('select[name="lvl"]').val(0); }
function clearCrid(){ $('select[name="crid"]').val(0); }



</script>


<?php 


$get = sages($_GET);
$get = str_replace('view=1','view=0',$get);
$all = str_replace('active=1','&all',$get);


?>

<style>
tr.headrow2 > th { color:blue; background:#ccc;}

</style>


<h5 class="fp120 screen">

	<span class="u" ondblclick="traceshd();" >Report</span>
	<span class="shd" >SHD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."ledgers/filter"; ?>' ><?php echo "Filter"; ?></a>	
	| <a class="u" id="btnExport" >Excel</a> 
	| <a href='<?php echo URL."ledgers/filter$get"; ?>' >No View</a> 
	| <a href='<?php echo URL."ledgers/report"; ?>' >Report</a> 
	| <a href='<?php echo URL."ledgers/filter$all"; ?>' >All</a> 
	

</h5>
	

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<?php if($empty){ exit; } ?>

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow2" >
	<th>#</th>
<?php if(!$has_sy): ?>	
		<th>SY</th>
<?php endif; ?>			
	<th>Classroom</th>
	<th>ID No.</th>
	<th>Student</th>
	<th>Mode</th>
	<th class="right" >Assessed</th>
	<th class="right" >Discounts</th>
	<th class="right" >Addons</th>
	<th class="right" >T Paid</th>
	<th class="right" >Paid</th>
	<th class="right" >Balance</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
<?php if(!$has_sy): ?>	
	<td><?php echo $rows[$i]['sy']; ?></td>
<?php endif; ?>			
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['paymode']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['discounts'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['addons'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['tpaid'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['paid'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['balance'],2); ?></td>
	<?php if($view): ?>
		<td><a href='<?php echo URL."ledgers/student/".$rows[$i]['scid']; ?>' >View</a></td>
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>



<!---------------------------------------------------------------------------->

