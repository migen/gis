<?php 


	// pr($classrooms);
	// pr($_SESSION['q1']);
	

	// debug($row);
	// if(isset($scid)){ pr($row); }
	
?>





<h5 class="fp120 screen">
	Promoter | <?php $this->shovel('homelinks'); ?>
	| <?php echo "SY ".$sy; ?>
	| <span class="u" onclick="traceshd();" >Detailed</span>

</h5>



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
	<tr><th>Student</th><td  ><?php echo $row['studname']; ?></td></tr>
	<tr><th>Level-Secton (Current)</th><td  ><?php echo $row['curr_level'].' - '.$row['section']; ?></td></tr>

	<tr><th class="vc200" >Promotion</th><td class="vc300" >
		<select id="promlvl" name="promlvl" class="vc200"  >
			<option <?php echo ($row['promlvl']==$row['nextlvl'])? "selected":NULL; ?> 
				value="<?php echo $row['nextlvl']; ?>" >Promoted - <?php echo $row['next_level']; ?></option>
			<option <?php echo ($row['promlvl']==$row['currlvl'])? "selected":NULL; ?> 
				value="<?php echo $row['currlvl']; ?>" >Retained - <?php echo $row['curr_level']; ?></option>
		</select>			
	</td></tr>

	
</table>

<br />
<?php if(!$is_promoted): ?>
		<input onclick="postAxnPage();" type="submit" name="submit" value="Save"  />		
<?php endif; ?>	<!-- is_promoted -->

<?php $srid=$_SESSION['srid']; ?>
<?php if(($srid==RMIS) || ($srid==RREG)): ?>
		<input onclick="postAxnPage();" type="submit" name="submit" value="Save On"  />		
<?php endif; ?>

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
	var url = gurl + '/promoters/student/'+ucid;	
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
