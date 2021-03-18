<?php 

// pr($nt);
// pr($rows[2]);

$size=isset($_POST['size'])? $_POST['size']:1;
$color=isset($_POST['color'])? $_POST['color']:'000';

?>


<div style="width:1200px;float:left;font-size:<?php echo $size; ?>em;color:<?php echo $color; ?>;"  >
<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-fx table-altrow"  >
<tr> 
	<th>#</th>
	<th>Multi</th>
	<th>Prid</th>
	<th class="" >Group</th>	
	<th class="vc100" >Barode</th>
	<th class="vc100" >Comm</th>
	<th class="vc100" >Code</th>
	<th class="vc200" >Name</th>
	<th>Price</th>	
	<th>Combo</th>
	<th>Pri-Supp</th>
	<th>Pri-Cost</th>
	

	<th>RO Lvl</th>
	<th>RO Qty</th>	
	<?php for($t=1;$t<=$nt;$t++): ?>
		<th><?php echo "t{$t}"; ?></th>
	<?php endfor; ?>
	
	<th>Level</th>			
	<th>Decimal</th>			

</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$prid=$rows[$i]['prid'];
?>
<tr>
	<td><?php echo $i+1;  ?></td>
	<td><?php $multi = $rows[$i]['multi']; echo ($multi)? 'Multi':'Add'; ?></td>
	<td><?php echo $prid;  ?></td>
	<td><?php echo $rows[$i]['prodsubtype_id']; ?></td>	
	<td><?php echo $rows[$i]['barcode']; ?></td>	
	<td><?php echo $rows[$i]['comm']; ?></td>	
	<td><?php echo $rows[$i]['code']; ?></td>		
	<td><?php echo $rows[$i]['name']; ?></td>	
	<td><?php echo $rows[$i]['price']; ?></td>	
	<td><?php echo $rows[$i]['combo']; ?></td>	
	<td><?php echo $rows[$i]['supplier']; ?></td>	
	<td><?php echo $rows[$i]['pcost']; ?></td>	
	
	<td><?php echo $rows[$i]['rolevel']; ?></td>	
	<td><?php echo $rows[$i]['roqty']; ?></td>	
	
	<?php for($t=1;$t<=$nt;$t++): ?>	
		<td><?php echo $rows[$i]['t'.$t]; ?></td>
	<?php endfor; ?>
	<td><?php echo $rows[$i]['level']; ?></td>	
	<td><?php echo $rows[$i]['is_decimal']; ?></td>	
	
		
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="update" value="Edit All" onclick="return confirm('Sure?');"  /></p>

</form>

</div> 	<!-- left -->




<!------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();


})






</script>




