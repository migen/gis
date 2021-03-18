<?php 

// pr($_SESSION['q1']);

// pr($classroom);
// pr($data);exit;

?>


<h5>
	<?php echo $classroom['name'].' Roster';  ?>
	<span id="rowCount" ><?php echo (isset($count))? " ($count)":NULL; ?></span>
	<?php $this->shovel('homelinks'); ?>	
	| Brid: <?php echo $_SESSION['brid']; ?> | 
<?php if($srid==RMIS): ?>
		Branch: <?php $d['branches']=$branches;$d['brid']=$brid;$this->shovel('selector_branches',$d); ?>			
<?php endif; ?>

	| Adv: <?php echo '#'.$classroom['acid'].' '.$classroom['adviser']; ?>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>'>Classlist</a>
	| <a href='<?php echo URL."students/sectioner"; ?>'>Sectioner</a>
	| <a href='<?php echo URL."syncs/syncEnrollments"; ?>'>SyncAll</a>

<?php if($_SESSION['srid']==RMIS || $_SESSION['srid']==RREG): ?>	
	| <a href="<?php echo URL.'rosters/batch'; ?>" >Batch</a>
	| <a href="<?php echo URL.'rosters/batchByScid'; ?>" >SCID</a>	
<?php endif; ?>

<?php if($mis): ?>	
	| <a href="<?php echo URL.'enrollment/manager/'.$crid.DS.$sy; ?>">Manager</a>	
<?php endif; ?>
	| <?php $this->shovel('links_gset'); ?>
	
	
</h5>

<?php 

$acid = $classroom['acid'];

// pr($rows[0]);
// pr($_SESSION['q']);

?>



<div class="clear" >
<table class='gis-table-bordered table-fx'>
<?php 
	$d['classrooms'] = $classrooms;
	$d['sy']		 = $sy;
	$d['axn']		 = 'classroom';
	$this->shovel('redirect_classroom',$d); 
?>
	

</table>
</div>

<p>*Summcrid > 0 will not be rostered. Need to be released first.</p>

<?php if($crid): ?>
<table id="roster" class="gis-table-bordered table-fx table-altrow"  >
<tr>
	<th class="vc100" >SCID</th>
	<th class="vc200" >ID Number</th>
	<th class="vc250" >Student</th>
	<th class="vc200" >Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $scid = $rows[$i]['scid']; ?>
<tr id="tr<?php echo $i; ?>" class="<?php echo (!$rows[$i]['is_active'])? 'red':NULL; ?>" >
	<td><?php echo str_pad($rows[$i]['scid'], 4, '0', STR_PAD_LEFT); ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><button id="btn-<?php echo $i; ?>" 
		onclick="releaseRoster(<?php echo $i.','.$scid; ?>);return false;" >Release</button></td>		
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
	<td class="vc200" ><input class="pdl05 pdl05 vc100" id="codes" readonly /></td>
	<td class="vc250" ><input class="pdl05 vc150" id="part" autofocus />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRosters();return false;" />		
	</td>
	<td class="vc200" >
		<input type="submit" value="Assign" onclick="rosterEnrollStudent(false);return false;"  />


		
	</td>
</tr>
</table>
</form>

<p class="brown" >
*Assign student to this classroom.
</p>

<div class="hd" id="names" > </div>


<div class="ht100" >&nbsp;</div>


<?php endif; ?>	<!-- if crid -->







<!-------------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var sy	 = "<?php echo $sy; ?>";
var count = "<?php echo $count; ?>";
var home = "<?php echo 'rosters'; ?>";
var hdpass 	= "<?php echo HDPASS; ?>";
var crid = "<?php echo $crid; ?>";
var acid = "<?php echo $acid; ?>";

$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	

})


function releaseRoster(i,scid){
	var row=$('#tr'+i);
	var vurl = gurl+'/ajax/xenrollment.php';			
	var task = "xenrollStudent";		
	var pdata="task="+task+"&sy="+sy+"&scid="+scid+"&crid=0";		
	$("#rowCount").html("("+(count-1)+")");
	
	$.ajax({
		url:vurl,type:"POST",data:pdata,
		success: function() { row.remove();$('#part').focus(); }		  
	});					

}	/* fxn */

function rosterEnrollStudent(){
	var scid = $('#scid').val();
	var stud = $('#part').val();
	var code = $('#codes').val();		

	var vurl = gurl+'/ajax/xenrollment.php';			
	var task = "xenrollStudent";		
	var pdata="task="+task+"&sy="+sy+"&scid="+scid+"&crid="+crid;
		
	$.ajax({
		url:vurl,type:"POST",data:pdata,
		success: function() { 
			$("#form")[0].reset();	$('#part').focus();
			$('#roster').append('<tr><td>'+scid+'</td><td>'+code+'</td><td>'+stud+'</td><td></td></tr>');	  
		}		  
	});					


}	/* fxn */


function axnPage(ucid){
	$('#scid').val(ucid);	
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetStudentByUcid";	
		
	$.post(vurl,{task:task,ucid:ucid},function(s){		
		$('#prevcrid').val(s.crid);		
		$('#part').val(s.name);		
		$('#codes').val(s.code);						
	},'json');	

	
}	/* fxn */


function xgetContactsByPartRosters(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xrosters.php';	
	var task = "xgetStudentsByPartRosters";	
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnPage(this.id);return false;" >'+s[i].name+' - '+s[i].account+' - '+s[i].code+' #'+s[i].id+' R#'+s[i].role_id+' Summcrid#'+s[i].crid+'</span></p>';
}	
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */

</script>


<script type="text/javascript" src='<?php echo URL."views/js/rosters_past.js"; ?>' ></script>
