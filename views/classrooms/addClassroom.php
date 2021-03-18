<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbsections="{$dbo}.05_sections";
	$dbclassrooms="{$dbg}.05_classrooms";
	
	// pr($data);

?>
<h3>
	Add Classroom | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tests/ledger"; ?>' >Ledger</a>
	| <a href='<?php echo URL."tests/links"; ?>' >Links</a>
	| <a href="<?php echo URL.'tests/ledger'; ?>">Ledger</a>


</h3>

<p class="b brown" >*Check both Section and Classroom first.</p>
<p class="b brown" >*Level and Section-ID required to add a classroom.</p>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Sections" onclick='getDataByTable(dbsections,30);return false;' />
		<input type="submit" name="auto" value="Classroom" onclick='getDataByTable(dbclassrooms,30);return false;' />
		
	</td></tr>
	
</table></p>

<div id="names" >names</div>

	<table class="gis-table-bordered" >
	<tr>
		<th>Add Section</th>
		<td><input id="code" placeholder="Code" ></td>
		<td><input id="name" placeholder="Section" ></td>
		<td><button onclick="addSection();" >Add Section</button></td>
	</tr>
	</table>

<br />

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th colspan=2>Add Classroom</th>
</tr>
<tr>
	<th>Level</th>
	<td>
		<select id="level_id" name="post[level_id]" >
			<option value=0>Select Level</option>
			<?php foreach($levels AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>
<tr>
	<th>Section ID</th>
	<td><input id="section_id" name="post[section_id]" class="vc100" ></td>
</tr>
<tr>
	<td colspan=2>
		<input type="submit" name="submit" value="Add classroom" >
	</td>
</tr>

</table>

</form>



<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbsections = "<?php echo $dbsections; ?>";
var dbclassrooms = "<?php echo $dbclassrooms; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	// alert(id);
	$('#section_id').val(id);
	// var url=gurl+"/tests/encrid/"+id+"/"+sy;
	// window.location=url;
}


function addSection(){
	const url=gurl+"/ajax/xdata.php";
	const task="xsaveData";
	const code=$("#code").val();
	const name=$("#name").val();	
	var pdata="task="+task+"&code="+code+"&name="+name+"&dbtable="+dbsections;
		
	if(!code) alert('Code required.');
	if(!name) alert('Name required.');

	if(code && name){
		$.ajax({
			url:url,type:"POST",data:pdata,
			success:(function(){ location.reload(); })		
		})	
	} 	
	
}	/* fxn */


function addClassroom(){
	const url=gurl+"/ajax/xdata.php";
	const task="xsaveData";
	const lvl=$("#level_id").val();
	const sxn=$("#section_id").val();
	var pdata="task="+task+"&level_id="+lvl+"&section_id="+sxn+"&dbtable="+dbclassrooms;

	if(lvl==0) alert('Level required.');
	if(!sxn) alert('Section-ID required.');

	if(lvl>0 && sxn){
		$.ajax({
			url:url,type:"POST",data:pdata,
			success:(function(){ location.reload(); })		
		})	
	} 
	
	
}	/* fxn */





</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

