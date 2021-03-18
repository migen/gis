<?php 




?>

<h5>
	Tickets
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href="<?php echo URL.'tickets/add'; ?>" >Add</a>
	| <a onclick="traceshd();"  >More</a>
	
	<?php // pr($_SESSION['actions']); ?>	
</h5>

<form method="GET" >
<table class="gis-table-bordered" >
<tr>
	<?php if($_SESSION['srid']==RMIS): ?>
		<td>ECID <input class="vc40 pdl05" name="ecid" value="0" /></td>	
	<?php endif; ?>
	<td>
		<select name="is_done" class="vc80" >
			<option value="0" >Undone</option>
			<option value="1" >Done</option>
			<option value="2" >All</option>
		</select>	
	</td>
	<td>Page <input class="vc40 pdl05" name="page" value="1" /></td>
	<td>Limits <input class="vc40 pdl05" name="limits" value="20" /></td>

	<td><input type="submit" name="filter" value="Filter"  /></td>
</tr>
</table>
</form>
<br />


<!------------------------------------------------------------------->
<?php if(isset($_GET['filter'])): ?>	<!-- filter -->
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>ID</th>
	<th>Created</th>
	<th>Is</th>
	<th>Done</th>
	<th>Employee</th>
	<th>Status</th>
	<th>Action</th>
	<th>Qtr</th>
	<th>Classroom</th>
	<th>Course</th>	
	<th>Memo</th>	
	<th class="shd" >Student</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$qtr = $rows[$i]['qtr']; 
	$cond1 = ($rows[$i]['action_id']==$_SESSION['axn']['open_course'])? true:false;
	$cond1a = ($rows[$i]['crsid']>0)? true:false;
	$cond1b = ($rows[$i]['crs_fq'.$qtr]==1)? true:false;
	
	$cond2 = ($rows[$i]['action_id']==$_SESSION['axn']['open_classroom'])? true:false;	
	$cond2a = ($rows[$i]['crid']>0)? true:false;
	$cond2b = ($rows[$i]['adv_fq'.$qtr]==1)? true:false;
	
?>
<tr>
	<td><?php echo $rows[$i]['tid']; ?></td>
	<td><?php echo $rows[$i]['created']; ?></td>
	<td><?php echo ($rows[$i]['is_done']==1)? 'Y':'-'; ?></td>
	<td><?php echo $rows[$i]['done']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td>
		<?php if($cond1): ?>
			<?php echo ($cond1b)? 'Locked':'Open'; ?>
		<?php endif;?>
		<?php if($cond2): ?>
			<?php echo ($cond2b)? 'Locked':'Open'; ?>
		<?php endif;?>		
	</td>
	<td><?php echo $rows[$i]['action']; ?></td>
	<td><?php echo $rows[$i]['qtr']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['memo']; ?></td>
	<td class="shd" ><?php echo $rows[$i]['student']; ?></td>
	<td>
		<?php if($rows[$i]['is_done']==1): ?>
			<a id="stat<?php echo $i; ?>" class="u txt-blue" onclick="undoTicket(<?php echo $rows[$i]['tid'].','.$i; ?>);return false;" >Undo</a>		
		<?php else: ?>
			<a id="stat<?php echo $i; ?>" class="u txt-blue" onclick="doTicket(<?php echo $rows[$i]['tid'].','.$i; ?>);return false;" >Done</a>
		<?php endif; ?>		
	
<?php if($_SESSION['srid']==RMIS): ?>	<!-- mis -->
		<?php if($cond1): ?>
			<a href='<?php echo URL."averages/course/".$rows[$i]['crsid']; ?>' >Ave</a>
			<?php if($cond1a && $cond1b): ?>
					| <a onclick="openCourse(<?php echo $rows[$i]['crsid'].','.$rows[$i]['qtr'].','.$i.','.$rows[$i]['tid']; ?>);return false;" 
						class="u txt-blue" id="btn<?php echo $i; ?>" >Open</a>
			<?php endif; ?>			
		<?php endif; ?>	
		
		<?php if($cond2): ?>		
			<a href='<?php echo URL."submissions/view/".$rows[$i]['crid']; ?>' >Sub</a>
			<?php if($cond2a && $cond2b): ?>
					| <a onclick="openClassroom(<?php echo $rows[$i]['crid'].','.$rows[$i]['qtr'].','.$i.','.$rows[$i]['tid']; ?>);return false;" 
						class="u txt-blue" id="btn<?php echo $i; ?>" >Open</a>
			<?php endif; ?>						
		<?php endif; ?>	

<?php endif; ?>		<!-- mis -->
	</td>
	
	
</tr>
<?php endfor; ?>
</table>

<?php endif; ?>	<!-- filter -->

<script>
var gurl = 'http://<?php echo GURL; ?>';

$(function(){
	// alert(gurl);
})

function doTicket(tid,i){
	$('#stat'+i).hide();
	var vurl = gurl+'/ajax/xtickets.php';		
	var task = "doTicket";
	var pdata = "task="+task+"&tid="+tid;
	// alert(pdata);

	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,	  	  			  
	  success:function(){} 
   });				
	

}	/* fxn */


function undoTicket(tid,i){
	$('#stat'+i).hide();
	var vurl = gurl+'/ajax/xtickets.php';		
	var task = "undoTicket";
	var pdata = "task="+task+"&tid="+tid;

	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,	  	  			  
	  success:function(){} 
   });				
	
}	/* fxn */



function openCourse(crsid,qtr,i,tid){
	$('#btn'+i).hide();
	
	var vurl = gurl+'/ajax/xtickets.php';		
	var task = "openCourse";
	var pdata = "task="+task+"&crsid="+crsid+"&qtr="+qtr+"&tid="+tid;

	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,	  	  			  
	  success:function(){} 
   });				
	
}	/* fxn */


function openClassroom(crid,qtr,i,tid){
	$('#btn'+i).hide();
	
	var vurl = gurl+'/ajax/xtickets.php';		
	var task = "openClassroom";
	var pdata = "task="+task+"&crid="+crid+"&qtr="+qtr+"&tid="+tid;

	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,	  	  			  
	  success:function(){} 
   });				
		

}	/* fxn */



</script>
