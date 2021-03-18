<?php 

$dbg=PDBG;
$dbtable="{$dbg}.01_courses";

?>

<h5>
	CCL <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<p>
	<?php foreach($majors AS $row): ?>
		<a href="<?php echo URL.'unilocks/major/'.$row['id']; ?>" ><?php echo $row['code']; ?></a> &nbsp; 	
	<?php endforeach; ?>
</p>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Major</th>
	<th>Course</th>
	<th>Status</th>
	<th></th>

</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['crs']; ?>
<tr>
	<td><?php echo $i+1; ?>
		<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $id; ?>" />
	</td>
	<td><?php echo $rows[$i]['major_code']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td>
		<?php $is_locked=($rows[$i]['is_finalized']==1)? 1:0;  ?>
		<select name="posts[<?php echo $i; ?>][is_finalized]"  />
			<option value=1 <?php echo ($is_locked)? 'selected':NULL; ?> >Locked</option>
			<option value=0 <?php echo (!$is_locked)? 'selected':NULL; ?> >Open</option>		
		</select>
	</td>
	<td><button id="btn-<?php echo $i; ?>" onclick="xeditData(<?php echo $i; ?>);" >Save</button></td>
</tr>
<?php endfor; ?>
</table>



<script> 

var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";

$(function(){ 

	
}) 	


function xeditData(i){
	// $('#btn-'+i).hide();
	var id=$('input[name="posts['+i+'][id]"]').val();
	var is_finalized=$('select[name="posts['+i+'][is_finalized]"]').val();
	var vurl=gurl+'/ajax/xsaveData.php';	
	var task="xeditData";	
	
	$.ajax({
		url:vurl,type:"POST",data:"task="+task+"&dbtable="+dbtable+"&is_finalized="+is_finalized+"&id="+id,
		success: function() { $('#btn-'+i).hide(); }		  
    });				
	
}	/* fxn */




</script>


