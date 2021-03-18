<?php 

	// pr($data); 
// pr($_SESSION['q']);


// pr($_SESSION);

// pr($levels);	
// pr($home);
	
?>

<h5> Registration / Enrollment 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
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





<div class="third" >	<!-- left -->



<?php  
	$inc="accor_registration";
	if($_SESSION['srid']==RTEAC){ $inc="accor_teacreg"; }
	$this->shovel($inc);  
?>


</div>	<!-- left -->

<div class="third" >
	<div id="names" ></div>
</div> <!-- right -->




<div class="ht100" ></div>





<script>

	var gurl  = "http://<?php echo GURL; ?>";	
	var sy    = "<?php echo $sy; ?>";
	var qtr   = "<?php echo $qtr; ?>";
	var sqtr  = "<?php echo $sqtr; ?>";
	var home  = "<?php echo $home; ?>";
	
	$(function(){
		hd();		
		$('html').live('click',function(){ $('#names').hide(); });
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
	window.location = rurl;		
}	
	
function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }


	
</script>

 


