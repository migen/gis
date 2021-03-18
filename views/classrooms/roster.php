<h5>
	<?php echo $classroom['name'].' Roster'; echo (isset($count))? " ($count)":NULL; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
</h5>

<?php 

$acid = $classroom['acid'];

?>


<p></p>

<?php if($crid): ?>
<table id="roster" class="gis-table-bordered table-fx table-altrow"  >
<tr class="" >
	<th class="vc100" >SCID</th>
	<th class="vc200" >ID Number</th>
	<th class="vc250" >Student</th>
	<th>Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $scid = $rows[$i]['scid']; ?>
<tr id="tr<?php echo $i; ?>" >
	<td><?php echo str_pad($rows[$i]['scid'], 4, '0', STR_PAD_LEFT); ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td>		
		<?php echo $i+1; ?>
		| A<?php echo ($rows[$i]['is_active']==1)? '1':'0'; ?>
		| <a class="u" onclick="moveToTmp(<?php echo $i.','.$scid; ?>);return false;"  />TMP</a>
		| <a class="u" onclick="moveToOut(<?php echo $i.','.$scid; ?>);return false;"  />Out</a>
		| <a class="u" href="<?php echo URL.'contacts/ucis/'.$scid; ?>"  />Edit</a>		
	</td>
</tr>
<?php endfor; ?>
</table>

<p></p>
<form id="form" >
<table class="gis-table-bordered" >
<tr>
	<td class="vc100" >
		<input readonly id="scid" class="pdl05 vc60" value="0" />
		<input type="hidden" id="prevcrid" class="pdl05 vc60" value="0" />		
		<input type="hidden" id="acid" class="pdl05 vc60" value="0" />		
	</td>
	<td class="vc200" >
		<input class="pdl05 pdl05 vc100" id="codes"  />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" />	
	</td>
	<td class="vc250" ><input class="pdl05 vc150" id="part" autofocus />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />		
	</td>
	<td>
		<input type="submit" value="Add" onclick="addRoster();return false;"  />
	</td>
</tr>
</table>
</form>

<div class="hd" id="names" > </div>


<div class="ht100" >&nbsp;</div>


<?php endif; ?>	<!-- if crid -->







<!-------------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var sy	 = "<?php echo $sy; ?>";
var home = "<?php echo 'registrars'; ?>";
var hdpass 	= "<?php echo HDPASS; ?>";
var crid = "<?php echo $crid; ?>";
var acid = "<?php echo $acid; ?>";
var tmpcrid = "<?php echo $tmpcrid; ?>";
var outcrid = "<?php echo $outcrid; ?>";

$(function(){
	$('html').live('click',function(){
		$('#names').hide();
	});
	

})



function redirContact(ucid){
	$('#scid').val(ucid);	
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetStudentByUcid";	
		
	$.post(vurl,{task:task,ucid:ucid},function(s){		
		// $('#acid').val(s.acid);		
		$('#prevcrid').val(s.crid);		
		$('#part').val(s.name);		
		$('#codes').val(s.code);						
	},'json');	

	
}	/* fxn */


function addRoster(){
	var scid = $('#scid').val();
	var stud = $('#part').val();
	var code = $('#codes').val();	
	var prevcrid = $('#prevcrid').val();	
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "xeditRoster";			
	var pdata  = "task="+task+"&scid="+scid+"&crid="+crid+"&prevcrid="+prevcrid+"&acid="+acid;
	// alert('crid: '+crid+', prevcrid: '+prevcrid+', code: '+code+', acid: '+acid);
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){
		$("#form")[0].reset();		
		$('#part').focus();
		$('#roster').append('<tr><td>'+scid+'</td><td>'+code+'</td><td>'+stud+'</td><td></td></tr>');	  
	  } 
	});				

}	/* fxn */


function moveToTmp(i,scid){

	var row = $('#tr'+i);
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "moveToTmp";			
	var pdata  = "task="+task+"&scid="+scid+"&tmpcrid="+tmpcrid+"&crid="+crid;
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){
		row.remove();
		$('#part').focus();
	  } 
	});				

}


function moveToOut(i,scid){

	var row = $('#tr'+i);
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "moveToOut";			
	var pdata  = "task="+task+"&scid="+scid+"&outcrid="+outcrid+"&crid="+crid;
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){
		row.remove();
		$('#part').focus();
	  } 
	});				
}	/* fxn */



function registerStudent(){
	var stud = $('#part').val();
	var code = $('#codes').val();		
	var prevcrid = $('#prevcrid').val();		
	// alert('crid: '+crid+', prevcrid: '+prevcrid+', code: '+code+', acid: '+acid);
	
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "registerStudent";			
	var pdata  = "task="+task+"&stud="+stud+"&code="+code+"&crid="+crid+"&acid="+acid;
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){
		$("#form")[0].reset();		
		$('#part').focus();
		$('#roster').append('<tr><td></td><td>'+code+'</td><td>'+stud+'</td><td></td></tr>');	  
	  } 
	});				

}	/* fxn */


</script>



<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
