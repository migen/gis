<h5>
	<?php echo ($level_id)? $level['name']:NULL; ?> Courses (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'setup/loading?all'; ?>" />All</a>  
	| <a href='<?php echo URL."gset/courses/$level_id"; ?>' />Batch Subjects</a>  
	| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>
	
	
</h5>



<?php 

// pr($_SESSION['q']);
// pr($rows[0]);

?>


<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."setup/loading/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<div style="float:left;width:60%" >	<!-- left -->
<form method="POST" >
<table class='gis-table-bordered table-fx table-altrow'>
<tr class="headrow" >
	<th><input type="checkbox" id="chkAlla" /></th>
	<th>Crs#</th>
	<th>Actv</th>
	<th>Classroom</th>
	<th>Subject</th>
	<th>Teacher</th>
	<th>Code</th>
	<th class="vc60" >TCID</th>
	<th>Manage</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr class="<?php echo ($rows[$i]['is_active']!=1)? 'bg-pink':NULL; ?>" >
	<td><input class="chka" type="checkbox" name="rows[<?php echo $i; ?>]" 
		value="<?php echo $rows[$i]['crsid']; ?>" /></td>
	<td><?php echo $rows[$i]['crsid']; ?></td>
	<td><?php echo $rows[$i]['is_active']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td>
		<?php $substr_teac = substr($rows[$i]['teacher'],0,12); ?>	
		<input class="vc100 pdl05" id="part<?php echo $i; ?>" value="<?php echo $substr_teac; ?>" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRow(<?php echo $i; ?>);return false;" />
	</td>
	<td><input id="tcode<?php echo $i; ?>" onchange="xgetTeacher(<?php echo $i; ?>);" tabIndex="2" /></td>
	<td><input id="tcid<?php echo $i; ?>" class="tcid pdl05 full" name="posts[<?php echo $i; ?>][tcid]" 
			value="<?php echo $rows[$i]['tcid']; ?>"  /></td>		
		
	<td>
		<a href="<?php echo URL.'mis/editCourse/'.$rows[$i]['crsid']; ?>">Edit</a>
		| <a href="<?php echo URL.'mis/delcrs/'.$rows[$i]['crsid']; ?>">Purge</a>
		| <a id="btn<?php echo $i; ?>" class="txt-blue u" onclick="xeditTcid(<?php echo $i.','.$rows[$i]['crsid']; ?>);"  >Save</a>
	</td>
	<input type="hidden" name="posts[<?php echo $i; ?>][crsid]" value="<?php echo $rows[$i]['crsid']; ?>" />
</tr>
<?php endfor; ?>
</table>

<p>	
	<input onclick="return confirm('Sure?');" type='submit' name='batch' value='Purge' >
	<input onclick="return confirm('Sure?');" type='submit' name='save' value='Save All' >

</p>
</form>

</div>	<!-- left -->

<div class="fourth hd" id="names" > </div>


<p class="smartboard" >
<select id="classbox" >
	<option value="tcid" >Teacher</option>
</select>
</p>
<?php $this->shovel('smartboard'); ?>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

		
$(function(){
	itago('smartboard');
	chkAllvar('a');
	hd();
	$('#hdpdiv').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});
	
	
})


function rowVal(i,tcid){
	$('input[name="posts['+i+'][tcid]"]').val(tcid);	
}	/* fxn */


function redirContact(pcid,rid){	
	$('input[name="posts['+rid+'][tcid]"]').val(pcid);		
}	/* fxn */


function xeditTcid(i,crsid){
	$('#btn'+i).hide();
	var tcid=$('#tcid'+i).val();
	var vurl 	= gurl + '/ajax/xcourses.php';	
	var task	= "xeditTcid";	
	var pdata = "task="+task+"&crsid="+crsid+"&tcid="+tcid;		
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
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
<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

