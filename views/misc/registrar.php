<?php 

	// pr($data); 
// pr($_SESSION['q']);


// pr($_SESSION);

// pr($levels);	
// pr($home);
	
?>

<h5> Registrar Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	 | <a href="<?php echo URL.'registrars/registration'; ?>"> <?php echo 'Registration'; ?></a> 
	 | <a href="<?php echo URL.'dashboard/registrar'; ?>"> <?php echo 'Dashboard'; ?></a> 
	 | <a href="<?php echo URL.'contacts/ucis'; ?>"> <?php echo 'UCIS'; ?></a> 
</h5>


<?php 
	
$qtr	= 	$_SESSION['qtr'];		
$ssy 	= $_SESSION['sy'];
$sqtr 	= $_SESSION['qtr'];

?>



<!-- ========================= table =========================  -->
<p>
<table class="gis-table-bordered table-fx" >
	<tr>
		<th class="hd bg-blue2 white" >HD</th>
		<th class="bg-blue2 white" >SY</th><td><input id="sy" class="pdl10 vc80" type="number" value="<?php echo $ssy;  ?>" onchange="syqtr();" /></td>
		<th class="bg-blue2 white" >Qtr</th><td><input id="qtr" class="pdl10 vc50" type="number" value="<?php echo $sqtr;   ?>"  onchange="syqtr();"  /></td>
	</tr>
</table>
</p>



<?php 
	$d['classrooms'] = $classrooms; 
	$d['levels'] = $levels; 
?>

<div class="accordParent" >	
<button onclick="accorToggle('general')" style="width:274px;" class="bg-blue2" > <p class="b f16" >General</p> </button>  	
<table id="general" class="gis-table-bordered table-fx" >

<tr><td><a class="b" href="<?php echo URL.'cir/index'; ?>" >*CLASS INDEX REPORTS (CIR)</a></td></tr>

<tr><td> 
<select class="vc200" onchange="jsredirect('classlists/classroom/'+this.value+'/'+sy);" >
	<option value="0">Class List</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>






<!----------------------------------------------------------------------------------------------------->


<tr><td> 
<select class="vc200" onchange="jsredirect('profiles/classroom/'+this.value+'/'+sy+'/'+qtr);" >
	<option value="0">Profiling</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>


<tr><td> <a href='<?php echo URL."files/notes"; ?>' >*NOTES</a></td></tr>
<tr><td> <a href='<?php echo URL."registrars/sxns"; ?>' >All Students</a></td></tr>
<tr><td> <a href='<?php echo URL."registrars/attendanceEmployeesIndex"; ?>' >Attendance Employees Index</a></td></tr>
<tr><td> <a href='<?php echo URL."registrars/attdem"; ?>' >Attendance Daily Employees</a></td></tr>
<?php if($_SESSION['settings']['with_chinese']): ?>
	<tr><td><a href="<?php echo URL.'alien/ChineseIndex'; ?>" >Chinese Index</a></td></tr>
<?php endif; ?>
<tr><td> <a href='<?php echo URL."speed/informant"; ?>' >Informant</a></td></tr>

<tr><td>
	Photos
	| <a href="<?php echo URL.'photos/one/'.$_SESSION['pcid']; ?>" >Find</a> 
	
	| <select class="vc100" onchange="jsredirect('employees/photos/'+this.value);" >
	<option value="" >Roles</option>
	<option value="" >All</option>
	<?php foreach($roles AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go	
</td></tr>



</table>
</div>


<?php $this->shovel('accor_registrar',$d); ?>
















<div class="ht100" ></div>

<!----------------------------------------------------------------------------------->





<script>

	var gurl  = 'http://<?php echo GURL; ?>';	
	var sy    = '<?php echo $sy; ?>';
	var qtr   = '<?php echo $qtr; ?>';
	var sqtr  = '<?php echo $sqtr; ?>';
	var home  = '<?php echo $home; ?>';
	
	$(function(){
		hd();
		// alert(home);
	
	})
	
	function syqtr(){
		sy  = $('#sy').val();
		qtr = $('#qtr').val();		
	}	
	

	function redirClass(axn,crid){
		var rurl 	= gurl + '/'+home+'/'+axn+'/'+crid+'/'+sy;		
		window.location = rurl;		
	}

	
	function redirCrid(axn,crid){
		var rurl 	= gurl + '/registrars/'+axn+'/'+crid+'/'+sy+'/'+qtr;		
		window.location = rurl;		
	}

	function redirCls(axn,crid){
		var rurl 	= gurl + '/registrars/'+axn+'/'+sy+'/'+crid;		
		window.location = rurl;		
	}
	
	function redirTranscript(){
		var scode   = $('#scode').val();
		var rurl 	= gurl + '/registrars/transcript/'+scode;		// redirect url	
		// alert(rurl);
		window.location = rurl;		
	}
	
	function redirLevel(axn,lvlid){
		var sy  = $('#sy').val();
		var qtr = $('#qtr').val();	
		var rurl 	= gurl + '/'+home+'/'+axn+'/'+lvlid+'/'+sy+'/'+qtr;		// redirect url	
		window.location = rurl;		
	}

	
/* ------------------------------------------------ */


function getSubjects(val,sel){
	var url = gurl+'/registrars/getSubjects/'+sy;
		
	$.ajax({
		url: url,
		dataType: "json",
		type: 'POST',
		data: 'level=' + val,		
		async: true,		
		success: function(s) {
			var cs = (s).length;	
			var options = '<option>Choose one</option>';
			for (var a = 0; a < cs; a++) {
				options += '<option value="' + s[a].id + '">' + s[a].name + '</option>';
			}
			var tdoptions = "<select class='vc200' onchange='gotoLSR();' id='lsid' >"+options+"</select>";
			$('#'+sel).html(tdoptions);				
		
		}
	});	



}	/* fxn */
	
	
function gotoLSR(){
	var level 	= $('#slid').val();
	var subject = $('#lsid').val();
	
	var rurl 	= gurl + '/registrars/lsr/'+level+'/'+subject+'/'+sy+'/'+qtr;			
	// alert(rurl);
	window.location = rurl;		




}	
	
function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }


	
</script>

 
