<h5>
	Positions (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href='<?php echo URL."courses/teachers?all"; ?>' />All</a>  
	| <a href='<?php echo URL."courses/teachers?lvl=$lvl"; ?>' />Teachers</a>  

</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."courses/positions?lvl=".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<p>
<?php include_once('incs/filter_courses.php'); ?>
</p>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Crs</th>
	<th>Level</th>
	<th>Section</th>
	<th>Subject</th>
	<th>Course</th>
	<th>Teacher</th>
	<th class="" >Pos
		<br /><input class="pdl05 vc50" id="ipos" value="" /><br />	
		<input type="button" value="All" onclick="populateColumn('pos');" >							
	</th>
	<th>Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td><input id="pos<?php echo $i; ?>" class="pos pdl05 vc50" name="posts[<?php echo $i; ?>][position]" 
			tabIndex=2 value="<?php echo $rows[$i]['position']; ?>"  /></td>			
	<td>
		<a href="<?php echo URL.'courses/edit/'.$rows[$i]['crs']; ?>">Edit</a>
		| <a href="<?php echo URL.'mis/delcrs/'.$rows[$i]['crs']; ?>">Purge</a>
		| <a id="btn<?php echo $i; ?>" class="txt-blue u" onclick="xeditCrsPos(<?php echo $i.','.$rows[$i]['crs']; ?>);"  >Save</a>
	</td>
	<input type="hidden" name="posts[<?php echo $i; ?>][crsid]" value="<?php echo $rows[$i]['crs']; ?>" />			
</tr>
<?php endfor; ?>
</table>
</form>

<div class="ht50" ></div>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

		
$(function(){
	itago('smartboard');
	hd();
	selectFocused();
	
	
})




function xeditCrsPos(i,crsid){
	$('#btn'+i).hide();
	var pos=$('#pos'+i).val();
	var vurl 	= gurl + '/ajax/xcourses.php';	
	var task	= "xeditCrsPos";	
	var pdata = "task="+task+"&crsid="+crsid+"&pos="+pos;		
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){} 
   });				
	
}	/* fxn */


function xgetTeacher(i){
	var code = $('#tcode'+i).val();
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";			
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&code='+code,async: true,
		success: function(s) { 	$('#tcid'+i).val(s.id); }		  
    });				
		
}	/* fxn */

</script>

