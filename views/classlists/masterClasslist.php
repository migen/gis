<h5>
	Master Classlist | <?php echo $cr['classroom'].' - '.$cr['adviser']; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	
	
</h5>


<?php 

// pr($rows[0]); 
// pr($cr);

?>



<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID No.</th>
	<th style="width:30px;" >Actv</th>
	<th class="vc300" >Student</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr class="<?php echo ($rows[$i]['is_active']!=1)? 'red':NULL; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo ($rows[$i]['is_active']!=1)? 'NA':NULL; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>


<!------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})

</script>
