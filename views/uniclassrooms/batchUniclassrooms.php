<?php 

// pr($_SESSION['q1']);
$dbg=PDBG;
$dbtable="{$dbg}.01_classrooms";

?>

<h5>
	Batch Add College Classrooms
	| <?php $this->shovel('homelinks','College'); ?>
	| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>	
	| <a href="<?php echo URL.'unicourses/add/'.$crid; ?>" >+Sections</a>
	
</h5>

<div style="float:left;width:40%;" >


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="center" >
		Major<br />
		<select id="imajor" class="vc200" >	
			<option> Choose </option>
			<?php foreach($majors as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].' #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('major');" >
	</th>		
	<th class="center" >
		Section<br />
		<select id="isxn" class="vc150" >	
			<option> Choose </option>
			<?php foreach($unisections as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].' #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateColumn('sxn');" >
	</th>		
	<th></th>	
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 2; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr id="trow-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td>
		<select id="major<?php echo $i; ?>" class="major vc200" name="posts[<?php echo $i; ?>][major_id]" tabindex=2 >
			<option value=0 >Select One</option>
			<?php foreach($majors AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
	<td>
		<select id="sxn<?php echo $i; ?>" class="sxn vc150" name="posts[<?php echo $i; ?>][section_id]" tabindex=4 >
			<option value=0 >Select One</option>
			<?php foreach($unisections AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>		

	<td><button id="btn-<?php echo $i; ?>" onclick="xsaveUniclassrooms(<?php echo $i; ?>);return false;" >Save</button></td>
</tr>
<?php endfor; ?>

</table>

<p><input type="submit" name="submit" value="Create" /></p>

</form>

<p><?php $this->shovel('numrows'); ?></p>
<div class=" hd vc200" id="names" > </div>
</div>	<!-- main -->


<div class="" style="float:left;width:200px;"  >


<p class="smartboard" >
<select id="classbox" >
	<option value="major" >Major</option>
	<option value="sxn" >Section</option>

</select>
</p>
<?php $this->shovel('smartboard'); ?>
</div>



<!-- ------------------- -->


<script>

var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var dbtable="<?php echo $dbtable; ?>";

$(function(){
	itago('smartboard');
	nextViaEnter();
	$('html').live('click',function(){ $('#names').hide(); });

})


function xsaveUniclassrooms(i){
	var major_id=$('select[name="posts['+i+'][major_id]"]').val();
	var sxn=$('select[name="posts['+i+'][section_id]"]').val();
	var vurl=gurl+'/ajax/xsaveData.php';	
	var task="xsaveData";	
	
	$.ajax({
		url:vurl,type:"POST",data:"task="+task+"&dbtable="+dbtable+"&major_id="+major_id+"&section_id="+sxn,
		success: function() { $('#btn-'+i).hide(); }		  
    });				
	
}	/* fxn */





function redirContact(ucid){
	var url 		= gurl + '/students/sectioner/' + ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

