<?php 

// pr($rows[0]);
// pr($_SESSION['q']);

?>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Student</th>
	<th>Feetype</th>
	<th>Num</th>
	<th>Addons</th>
	<th>Discounts</th>
	<th>Due</th>
	<th>ID</th>	
	<th>Action</th>	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_discount']!=1)? number_format($rows[$i]['amount'],2):NULL; ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_discount']==1)? number_format($rows[$i]['amount'],2):NULL; ?></td>
	<td><?php echo $rows[$i]['due']; ?></td>
	<td><?php echo $rows[$i]['auxid']; ?></td>
	<td>
  <a href="<?php echo URL.'ledgers/pay/'.$rows[$i]['scid']; ?>" >Lgr</a>
| <a href="<?php echo URL.'addons/edit/'.$rows[$i]['auxid']; ?>" >Edit</a>
| <a id="btndt<?php echo $i; ?>" class="txt-blue u" onclick="deleteTaux(<?php echo $rows[$i]['auxid'].','.$i; ?>,false,<?php echo $sy; ?>);" >Del</a>	
	</td>
</tr>
<?php endfor; ?>


</table>

<script>



</script>

<script type="text/javascript" src='<?php echo URL."views/js/enroll.js"; ?>' ></script>
