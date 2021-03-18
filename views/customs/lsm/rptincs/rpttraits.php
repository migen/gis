<?php
	$conducts = $students[$i]['conducts'];

	// pr($student['summary']);
	
?>


<table class="tbp-right gis-table-bordered-print table-center table-vcenter" style="width:<?php echo $ftw; ?>;" >
<tr class="" >
	<th style="width:<?php echo $trw; ?>;" >CHRISTIAN ATTITUDE AND VALUES</th>
	<th style="width:<?php echo $qw; ?>;" >1</th>
	<th style="width:<?php echo $qw; ?>;" >2</th>
	<th style="width:<?php echo $qw; ?>;" >3</th>
	<th style="width:<?php echo $qw; ?>;" >4</th>		
	<th style="width:0.4in;" >Final</th>	
</tr>


<?php for($ic=0;$ic<$numtraits;$ic++): ?>
<tr>

	<td class="left" style="font-size:0.85em;width:<?php echo $trw; ?>;" >
		<?php echo $conducts[$ic]['trait']; ?></td>
	<td><?php echo $conducts[$ic]['dg1']; ?></td>
	<td><?php echo ($qtr>1)? $conducts[$ic]['dg2']:NULL; ?></td>
	<td><?php echo ($qtr>2)? $conducts[$ic]['dg3']:NULL; ?></td>
	<td><?php echo ($qtr>3)? $conducts[$ic]['dg4']:NULL; ?></td>
	<td><?php echo ($qtr>3)? $conducts[$ic]['dg5']:NULL; ?></td>
</tr>
<?php endfor; ?>
<tr>
	<th class="left" >AVERAGE</th>
	<th><?php echo $student['summary']['conduct_dg1']; ?></th>
	<th><?php echo ($qtr>1)? $student['summary']['conduct_dg2']:NULL; ?></th>
	<th><?php echo ($qtr>2)? $student['summary']['conduct_dg3']:NULL; ?></th>
	<th><?php echo ($qtr>3)? $student['summary']['conduct_dg4']:NULL; ?></th>
	<th><?php echo ($qtr>3)? $student['summary']['conduct_dg5']:NULL; ?></th>
</tr>


</table>
