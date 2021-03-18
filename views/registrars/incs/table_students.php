<script>

var hdpass 	= '<?php echo HDPASS; ?>';

	$(function(){
		excel();
		hd();
		$('#hdpdiv').hide();
		
	})

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



<p><?php $this->shovel('hdpdiv'); ?></p>

<table id="tblExport" class="gis-table-bordered" >

<tr class="headrow" >
	<th>#</th>
	<th>ID</th>
	<th>Classroom</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Sy</th>	
	<th>M</th>
	<th>A</th>
	<th>C</th>
	<th class="hd" >Crid</th>
	<th class="hd" >Sum<br />Acid</th>
	<th class="hd" >Stud<br />Scid</th>
	<th class="hd" >TSum<br />Scid</th>

</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><a href='<?php echo URL."students/sectioner/".$rows[$i]["scid"]; ?>' >
		<?php echo $rows[$i]['student_code']; ?></a></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>	
	<td><?php echo ($rows[$i]['is_male']==1)?'M':'-'; ?></td>
	<td><?php echo ($rows[$i]['is_active']==1)?'A':'-'; ?></td>
	<td><?php echo ($rows[$i]['is_cleared']==1)?'C':'-'; ?></td>
<span class="hd" >	
	<td class="hd" ><?php echo $rows[$i]['crid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['sumacid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['studscid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['tsumscid']; ?></td>
</span>
</tr>
<?php endfor; ?>
</table>


<?php 
/* 
	pr($_GET);
	pr($q); 
	
 */
 
?>