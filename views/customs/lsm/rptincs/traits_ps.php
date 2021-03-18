<?php
	$conducts = $students[$i]['conducts'];
	
?>


<table class="tbp-right gis-table-bordered-print table-center table-vcenter" style="width:100%;" >
<tr class="" >
	<th style="width:<?php echo $trw; ?>;" >CHRISTIAN ATTITUDE AND VALUES</th>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>

</tr>


<?php for($ic=0;$ic<$numtraits;$ic++): ?>
<tr>

	<td class="left" style="font-size:1.0em;color:;" >
		<?php echo $conducts[$ic]['trait']; ?></td>
	<td><?php echo $conducts[$ic]['dg1']; ?></td>
	<td><?php echo ($qtr>1)? $conducts[$ic]['dg2']:NULL; ?></td>
	<td><?php echo ($qtr>2)? $conducts[$ic]['dg3']:NULL; ?></td>
	<td><?php echo ($qtr>3)? $conducts[$ic]['dg4']:NULL; ?></td>
</tr>
<?php endfor; ?>


</table>
