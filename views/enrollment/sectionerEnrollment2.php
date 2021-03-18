<?php 


	// pr($classrooms);
?>



<h5 class="fp120 screen">
	Sectioner
	| <?php echo $sy.SPC; ?><span class="u" onclick="traceshd();" >Detailed</span>
	<?php echo ($current)? '':'(*NOT Current)'; ?>
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'contacts/ucis/'.$scid; ?>">UCIS</a> 
	| <a href="<?php echo URL.'registration/one'; ?>">Register</a> 
	| <a href="<?php echo URL.'profiles/student/'.$scid; ?>">Profile</a> 
	| <a href="<?php echo URL.'assessment/assess/'.$scid.DS.$sy; ?>">Assmt</a> 
	| <a href="<?php echo URL.'assessment/assess/'.$scid.DS.$sy; ?>"
		onClick="window.open(this.href,'hahaha','resizable,width=600,height=400');
 return false;">WinAssmt</a>


<div style="font-size:1.6em;">
<style> 
	#psy{ font-size:1em;}
</style>
School Year <?php 
	$d['sy']=$sy;$d['repage']="students/sectioner/$scid";
	$this->shovel('sy_selector',$d); 
?>	

<><>


</div> 

</h5>

<p><?php $this->shovel('hdpdiv'); ?></p>


<div class="half" >

<?php 
	// require_once(SITE.'/views/enrollment/incs/filter_codename.php');
	$this->shovel('filter_codename');

?>

<?php if(!empty($student)): ?>

<form method="POST" >
<table class="fp120 gis-table-bordered table-fx"  >
	<tr><th class="vc200" >ID | Pass</th><td class="vc300" >
		  <?php echo $student['student_code']; ?>
	</td></tr>
	<tr><th>Student</th><td  ><?php echo $student['student']; ?></td></tr>
	<tr><th>Section | Level</th><td>
		<a href='<?php echo URL."rosters/classroom/".$student['summcrid'].DS.$sy; ?>' >
			<?php echo $student['section']; ?></a>
		| <a href='<?php echo URL."sectioning/level/".$student['level_id'].DS.$sy; ?>' ><?php echo $student['level']; ?></a>
	</td></tr>
<?php if($_SESSION['settings']['has_axis']==1): ?>
	<tr><th>Assessed</th><td class="b" ><?php echo number_format($student['total'],2); ?></td></tr>		
<?php endif; ?>	
	
	
</table>

<p> <?php // pr ($student); ?> </p>

<?php if($student['role_id'] ==RSTUD): ?>
<table class="fp120 gis-table-bordered table-fx screen"  >

<?php if(!$current): ?>	
	<tr><th>Current | 
		<span class="u" onclick="promoteScid(<?php echo $sy.','.$scid.','.$currlvl; ?>);" >Promote</span>
	</th><td><?php echo $student['currclassroom'].' #'.$student['currcrid']; ?></td></tr>
<?php endif; ?>	
	
	<tr><th class="vc200" >Enroll</th><td class="vc300" >
		<select id="crid" name="crid" class="vc200"  >
			<option value="0">Choose Classroom</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($student['summcrid']==$sel['id'])? 'selected':NULL; ?>  > 
					<?php echo $sel['name'].' #'.$sel['id']; ?> 
				</option>	
			<?php endforeach; ?>			
		</select>			
		<?php if(!isset($_GET['all'])): ?><a href="?all" >All</a><?php endif; ?>
	</td></tr>

	

<!-- hd -->

		
	<tr><td colspan="2" >
		<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />
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
	$('#hdpdiv').hide();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){ $('#names').hide(); });


})

function setCsy(){
	$('#csy').val(dbyr);
}


function getAcid(){
	var crid = $('#crid').val();
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "clsAdvi";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&crid='+crid+'&sy='+sy,						
		success: function(s) { 
			// console.log(s);
			$('#acid').val(s.acid);			
		}		  
    });				

}	/* fxn */




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


</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
