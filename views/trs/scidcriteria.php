<h5>
	Student Trs - <?php echo $student['student'].' ('.$student['classroom'].')'; ?>
	
	
</h5>

<table class="gis-table-bordered hd" >
<tr><th>Crid#<?php echo $crid; ?></th><th>Crs#<?php echo $crs; ?></th>
<td><?php foreach($teachers AS $row){ echo $row['tcid'].'-'.$row['teacher'].' ('.$row['label'].') | '; } ?></td>
</tr>
</table>

<br />
<table class="gis-table-bordered table-fx table-altrow" >
<tr><th>TCID</th><th>Teacher</th><th>Grade</th><th>DELETE</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $trsid=$rows[$i]['trsid']; ?>
<tr id="trow<?php echo $i; ?>" >
<td><?php echo $rows[$i]['tcid']; ?></td>
<td><?php echo $rows[$i]['teacher']; ?></td>

<td><input class="vc50" onchange="editTrsgrade(this.value,<?php echo $trsid; ?>);" 
	value="<?php echo $rows[$i]['q'.$qtr]; ?>"  /></td>
<td><a class="u" onclick="deleteTrs(<?php echo $i.','.$rows[$i]['trsid']; ?>);" ><?php echo $trsid; ?></a></td>

</tr>
<?php endfor; ?>
</table>



<script>
var gurl="http://<?php echo GURL; ?>";
var qtr="<?php echo $qtr; ?>";

$(function(){
	nextViaEnter();
	selectFocused();
})

function deleteTrs(i,trsid){
	if (confirm('Sure?')){
		deltrow(i)
		var vurl = gurl+'/ajax/xtrs.php';		
		var task = "deleteTrs";			
		$.post(vurl,{task:task,trsid:trsid},function(){});			
	}
	return false;
	

}	/* fxn */

function editTrsgrade(grade,trsid){
	var vurl = gurl+'/ajax/xtrs.php';	
	var task = "editTrsgrade";	
	$.ajax({ 
		url:vurl,type:'POST',data: 'task='+task+'&qtr='+qtr+'&grade='+grade+'&trsid='+trsid,						
	});				
		
}	/* fxn */



</script>