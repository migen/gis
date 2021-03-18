
<h5>
	All Classrooms | 
	<?php 	$this->shovel('homelinks','mis'); ?>
	| <a href='<?php echo URL."mis/syncGradesPage"; ?>' >Manager</a>
	
</h5>

<?php 


// pr($rows[0]);

$with_chinese = $_SESSION['settings']['with_chinese'];

?>


<!------------------------------------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th>CRID</th>
	<th>Classroom</th>
	<th>Acid</th>
	<th>Adviser</th>
	<?php if($with_chinese): ?>
		<th>Chinese<br />Acid</th>
		<th>Chinese<br />Adviser</th>
		<th>Chinese</th>
	<?php endif; ?>
	<th>Advi</th>
	<th>Apass</th>
	<th>Hcid</th>
	<th>Head</th>
	<th>Class<br />List</th>
	<th class="center" >Manage</th>
</tr>

<?php for($i=0;$i<$num_rows;$i++): ?>

<tr class="<?php echo ($rows[$i]['is_active'])? null:'red' ?>"  >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['acid']; ?></td>
	<td><?php echo $rows[$i]['adviser']; ?></td>
	<?php if($with_chinese): ?>
		<td><?php echo $rows[$i]['chinese_acid']; ?></td>
		<td><?php echo $rows[$i]['chinese_adviser']; ?></td>
		<td><?php echo $rows[$i]['chinese_name']; ?></td>
	<?php endif; ?>
	<td><?php echo $rows[$i]['alogin']; ?></td>
	<td><?php echo $rows[$i]['apass']; ?></td>
	<td><?php echo $rows[$i]['hcid']; ?></td>
	<td><?php echo $rows[$i]['hlogin']; ?></td>
	<td><a href='<?php echo URL."classlists/classroom/".$rows[$i]['id'].DS.$sy; ?>' >View</a></td>
	<td>	

<!-- edit classroom button -->
		
<!-- courses -->
<button class="vc80" ><a class="txt-black no-underline" href="<?php echo URL.'mis/courses/'.$rows[$i]['id']; ?>" >Courses</a></button>
		
<!-- toggle status -->
<?php if($rows[$i]['is_active']): ?>
	<button class="csb<?php echo $i; ?> vc80" id="<?php echo $i; ?>"  ><a class="no-underline" id="<?php echo $i; ?>" onclick="xdisableClassroom(<?php echo $rows[$i]['id']; ?>,this.id);return false;"> Disable </a></button>			
<?php else: ?>
	<button class="csb<?php echo $i; ?> vc80" id="<?php echo $i; ?>" ><a class="no-underline" id="<?php echo $i; ?>" onclick="xenableClassroom(<?php echo $rows[$i]['id']; ?>,this.id);return false;"> Enable </a></button>									
<?php endif; ?>		
		
	</td>
</tr>

<?php endfor; ?>
</table>




<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){

	nextViaEnter();

})


function xdisableClassroom(crid,i){

	var vurl 	= gurl + '/mis/xdisableClassroom';	
	$(".csb"+i).hide();
	$('#status'+i).html('Inactive');			
		
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid,				
		async: true,
		success: function() { }		  
    });				

}	// fxn


function xenableClassroom(crid,i){

	var vurl 	= gurl + '/mis/xenableClassroom';	
	// $(".csb"+i).hide();
	$(".csb"+i).hide();
	$('#status'+i).html('Active');			
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid,				
		async: true,
		success: function() { }		  
    });				

}	// fxn


</script>