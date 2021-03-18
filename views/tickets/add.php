<?php 

// pr($data);

// pr($_SESSION['teacher']);
// $advisories = $_SESSION['teacher']['advisories'];
// pr($advisories);
// pr($courses);


?>

<h5>
	Add Service Request 
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'tickets'; ?>" >Tickets</a>
	| <a onclick="traceshd();" >More</a>
</h5>

<h4>
Please expect 24 to 48 hours for your request to be served.
</h4>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Action</th><td>
	<select name="action" class="full"  >
		<option value="0" >Select</option>
		<?php foreach($axn AS $k => $v): ?>
			<option value="<?php echo $v; ?>" ><?php echo $k; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><th>Quarter</th><td><input class="pdl05 " name="qtr" value="<?php echo $_SESSION['qtr']; ?>" /></td></tr>


<tr class="shd" ><th>SCID</th><td>
	<input class="pdl05 " id="scid" name="scid" value="0" readonly />
</td></tr>

<tr class="shd" >
	<th><span class="u b" ><span class="u b" >S</span>tudent</th>
	<td>
		<input style="padding-left:5px;width:200px;" id="part" accesskey="s" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
	</td>
</tr>


<tr><th>Classroom</th><td>
	<select name="classroom" class="full" >
		<option value="0" >Select</option>
		<?php foreach($advisories AS $k=>$row): ?>
			<option value="<?php echo $row['crid']; ?>" ><?php echo $row['classroom']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><th>Course</th><td>
	<select name="course" class="full"  >
		<option value="0" >Select</option>
		<?php foreach($courses AS $k=>$row): ?>
			<option value="<?php echo $row['course_id']; ?>" ><?php echo $row['course']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr>
<th>Memo (<span id="chars" >160</span>)</th>
<td><textarea name="memo" onkeyup="countChars(this.value);" ></textarea></td>
</tr>



</table>

<p>
	<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" />
	
</p>

</form>


<div class="hd" id="names" >names</div>



<script type='text/javascript' src="<?php echo URL; ?>views/js/filters.js"></script>

<script>
var gurl 	= 'http://<?php echo GURL; ?>';
var limits = "<?php echo $limits; ?>";

$(function(){
	hd();
	shd();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	/* fxn */

function countChars(txt){
	var len = txt.length;
	var left = parseInt(160)-parseInt(len);
	$('#chars').text(left);
}	/* fxn */


function redirContact(ucid){	
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetContactByID";	
		
	$.post(vurl,{task:task,pcid:ucid},function(s){		
		$('#part').val(s.name);		
		$('#scid').val(s.parent_id);				
	},'json');	
	
}	/* fxn */


</script>