<?php 


if(isset($_GET['edit'])){
	$rows=getSir($rows);
} 

$decigenave=$_SESSION['settings']['decigenave'];


?>


<h5>
	<?php echo $classroom['name']; ?>
	Genave Ranks - SIR (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" onclick="traceshd();" >SHD</a> 		
	| <a class="u" id="btnExport" >Export</a> 		
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>
	| <a href='<?php echo URL."submissions/view/$crid/$sy/$qtr"; ?>' >Submissions</a>
	| <a href='<?php echo URL."spiral/crid/$crid/$sy/$qtr"; ?>' >Spiral</a>
	| <a href='<?php echo URL."summarizers/genave/$crid/$sy/$qtr"; ?>' >Summarizer</a>
	| <a href='<?php echo URL."qcr/qcrall/$crid/$sy/$qtr"; ?>' >All</a>
	<?php if(isset($_GET['edit'])): ?>
		| <a href='<?php echo URL."sir/classroom/$crid/$sy/$qtr"; ?>' >View</a>	
	<?php else: ?>
		| <a href='<?php echo URL."sir/classroom/$crid/$sy/$qtr&edit"; ?>' >Edit</a>		
	<?php endif; ?>
</h5>

<p class="brown" >Click 1) Edit and 2) Submit - to update.</p>



<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="shd" >ID</th>
	<th class="" >ID No.</th>
	<th class="vc300 left" >Name</th>
	<th>Gen<br />Ave</th>
	<th>SIR</th>
</tr>

<?php // $r1=1; ?>
<?php for($i=0;$i<$count;$i++): ?>
<tr>

<?php if(isset($_GET['edit'])): ?>
	<td><?php echo $rows[$i]['ct']; ?></td>
<?php else: ?>
	<td><?php echo $i+1; ?></td>	
<?php endif; ?>

	<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="left" ><?php echo $rows[$i]['studcode']; ?></td>
	<td class="left" ><?php echo ucfirst($rows[$i]['student']); ?></td>
	<td class="rigth" ><?php echo number_format($rows[$i]['genave'],$decigenave); ?></td>

<?php if(isset($_GET['edit'])): ?>
	<td>
		<input name="posts[<?php echo $i; ?>][rank]" value="<?php echo $rows[$i]['rank']; ?>" >
		<input name="posts[<?php echo $i; ?>][sumxid]" value="<?php echo $rows[$i]['sumxid']; ?>" type="hidden" >	
	</td>
		
<?php else: ?>
	<td><?php echo $rows[$i]['classrank']; ?></td>
<?php endif; ?>


</tr>
<?php endfor; ?>
</table>

<br />
<?php if(isset($_GET['edit'])): ?>
	<input type="submit" name="submit" value="Update" >
<?php endif; ?>

</form>

<div class="ht50"></div>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";

$(function(){
	shd();
	excel();
	
})

</script>


