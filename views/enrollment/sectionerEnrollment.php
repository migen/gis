<?php 


	// pr($classrooms);
	// pr($_SESSION['q1']);
	

	// debug($row);
	
	
?>





<h5 class="fp120 screen">
	Enrollment 
	<?php $this->shovel('homelinks'); ?>
	| <?php echo $sy.SPC; ?><span class="u" onclick="traceshd();" >Detailed</span>

</h5>

<div style="font-size:1.6em;">
<style> #psy{ font-size:1em;} </style>

<span class="<?php echo ($sy==DBYR)? NULL:'red'; ?>" >
	<?php echo ($sy==DBYR)? "Current":NULL; ?> 
	<?php echo ($sy>DBYR)? "Next":NULL; ?> 
	<?php echo ($sy<DBYR)? "Past":NULL; ?> 
	
	&nbsp; School Year <?php 
	$d['sy']=$sy;$d['repage']="students/sectioner/$scid";
	$this->shovel('sy_selector',$d); 
?>	
</span>
</div> 


<p><?php $this->shovel('hdpdiv'); ?></p>


<div class="half" >

<?php 
	$this->shovel('filter_codename');

?>

<?php if(!empty($row)): ?>

<form method="POST" >
<table class="fp120 gis-table-bordered table-fx"  >
	<tr><th class="vc200" >ID | Pass</th><td class="vc300" >
		  <?php echo $row['studcode']; ?>
	</td></tr>
	<tr><th>SY</th><td><?php echo $sy.' - '.($sy+1); ?></td></tr>
	<tr><th>Student</th><td  ><?php echo $row['studname']; ?></td></tr>
	<tr><th>Classroom</th><td id="cellClassroom" >
		<a href='<?php echo URL."rosters/classroom/".$row['summcrid'].DS.$sy; ?>' >
			<?php echo $row['classroom']; ?></a>
	</td></tr>
	
	
</table>

<p> <?php // pr ($row); ?> </p>

<?php if($row['role_id'] ==RSTUD): ?>
<table class="fp120 gis-table-bordered table-fx screen"  >
<?php if(1==2): ?>
	<tr><th>Current | 
		<span class="u" onclick="promoteScid(<?php echo $sy.','.$scid.','.$currlvl; ?>);" >Promote</span>
	</th><td><?php echo $row['currclassroom'].' #'.$row['currcrid']; ?></td></tr>
<?php endif; ?>	
	<tr><th class="vc200" >Enroll</th><td class="vc300" >
		<select id="crid" name="crid" class="vc200"  >
			<option value="0">Choose Classroom</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" name="<?php echo $sel['name']; ?>" <?php echo ($row['summcrid']==$sel['id'])? 'selected':NULL; ?>  > 
					<?php echo $sel['name'].' #'.$sel['id']; ?> 
				</option>	
			<?php endforeach; ?>			
		</select>			
		<?php if(!isset($_GET['all'])): ?><a href="?all" >All</a><?php endif; ?>
	</td></tr>

	

<!-- hd -->

		
	<tr><td colspan="2" >
		<input onclick="postAxnPage();" type="submit" name="submit" value="Save"  />		
		<button onclick="xenrollStudent();return false;" >JS Save</button>		
	</td></tr>		


</table>
<?php endif; ?>	<!-- if student -->
</form>

<?php else: ?>	<!-- if student is empty -->
	<h5>No record found.</h5>
<?php endif; ?>	<!-- if student not empty -->




</div>


<div class="hd" id="names" > </div>


<div class="ht50 clear" >&nbsp;</div>


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy   = "<?php echo $sy; ?>";
var scid  = "<?php echo $scid; ?>";
var home = "<?php echo $home; ?>";
var dbyr = "<?php echo DBYR; ?>";
var hdpass 	= "<?php echo HDPASS; ?>";
var limits=100;
// var hdpass = CryptoJS.MD5("hello");




$(function(){
	// hd();
	// shd();
	// alert(sy);
	$('#hdpdiv').hide();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){ $('#names').hide(); });


})

function setCsy(){
	$('#csy').val(dbyr);
}



function redirContact(ucid){
	var url = gurl + '/students/sectioner/' + ucid + '/' + sy;	
	window.location = url;		
}


function getAssessed(lvl,tnum){
	var vurl = gurl+'/ajax/xassessment.php';		
	var task = "xgetTuition";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&lvl='+lvl+'&tnum='+tnum,						
		success: function(s) { $('#assessed').val(s.total); }		  
    });				

}	/* fxn */


function updateAssessed(lvl,tnum,scid){
	var vurl = gurl+'/ajax/xassessment.php';		
	var task = "xupdateAssessed";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&lvl='+lvl+'&tnum='+tnum+'&scid='+scid+'&sy='+sy,
		success: function(s) { $('#assessed').val(s.total); }		  
    });				

}	/* fxn */

function promoteScid(sy,scid,currlvl){
	var sure=confirm('Sure?');
	if(sure){
		var vurl = gurl+'/ajax/xsections.php';		
		var task = "xpromoteScid";		
		$.ajax({
			url: vurl,dataType: "json",type: 'POST',async: true,
			data: 'task='+task+'&sy='+sy+'&scid='+scid+'&currlvl='+currlvl,
			success: function() { location.reload(); }		  
		});					
	}
	
}

function xenrollStudent(){
	var crid=$('#crid').val();	
	var name=$('#crid').find('option:selected').attr("name");	
	var vurl = gurl+'/ajax/xenrollment.php';			
	var task = "xenrollStudent";		
	var pdata="task="+task+"&sy="+sy+"&scid="+scid+"&crid="+crid;
	// alert(pdata);
	
	$.ajax({
		url:vurl,type:"POST",data:pdata,
		success: function() { 
			$('#cellClassroom').text(name); 
		}		  
	});					
	
}	/* fxn */


function postAxnPage(){
	$('#cellClassroom').text("change classroom");
	var crid=$('select[name="crid"]').val();
	var classroom=$('select[name="crid"]').name();
	alert(crid+", "+classroom);
	
}	/* fxn */

</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
