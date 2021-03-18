<?php 

$casti = isset($attendance['casti'])? $attendance['casti']:TIMEIN;
$casto = isset($attendance['casto'])? $attendance['casto']:TIMEOUT;

?>


<h5>
	Edit Attendance
	| <a onclick="return confirm('Are you sure?');" href='<?php echo URL."$home/deleteAttendanceLog/$sy/".$attendance['id']."/$empl"; ?>' />Delete</a>  
	| <a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					




</h5>


<?php // pr($attendance); ?>



<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr><th>ID Number</th><td><?php echo $attendance['code']; ?></td></tr>
<tr><th>Name</th><td><?php echo $attendance['name']; ?></td></tr>
<tr><th>Schema Time In</th><td><?php echo $casti; ?></td></tr>
<tr><th>Schema Time Out</th><td><?php echo $casto; ?></td></tr>
<tr><th>Date</th><td><input class="pdl05 full" type="text" name="att[date]" value="<?php echo $attendance['date']; ?>" /></td></tr>
<tr><th>Time In</th><td><input onchange="minTardy(1);return false;" class="pdl05 full" id="ti-1" class="pdl05 full" type="text" name="att[timein]" value="<?php echo $attendance['timein']; ?>" /></td></tr>
<tr><th>Time Out</th><td><input onchange="minUnder(1);return false;" class="pdl05 full" id="to-1" class="pdl05 full" type="text" name="att[timeout]" value="<?php echo $attendance['timeout']; ?>" /></td></tr>
<tr><th>Minutes Tardy</th><td><input id="mt-1" class="pdl05 full" type="text" name="att[minutes_tardy]" value="<?php echo $attendance['minutes_tardy']; ?>" /></td></tr>
<tr><th>Minutes Undertime</th><td><input id="mu-1" class="pdl05 full" type="text" name="att[minutes_undertime]" value="<?php echo $attendance['minutes_undertime']; ?>" /></td></tr>

</table>

<input type="hidden" name="att[id]" value="<?php echo $attendance['id']; ?>" />

<p><input type="submit" name="submit" value="Save"   /></p>
</form>




<!------------------------------------------------------------------------->

<script>
var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';
var sy  = '<?php echo $sy; ?>';
var casti  = '<?php echo $casti; ?>';
var casto  = '<?php echo $casto; ?>';
			

$(function(){
	hd();

})

function minTardy(i){
	var ta = $('#ti-'+i).val();
	var tb = casti;
	var diff; 	
	if(ta>tb){
		diff = ( new Date("1970-1-1 " + ta) - new Date("1970-1-1 " + tb) ) / 1000 / 60 ; 
		diff = Math.round(diff);
	} else { diff=0;}
	$('#mt-'+i).val(diff);
}


function minUnder(i){
	var ta = casto;
	var tb = $('#to-'+i).val();
	var diff;	
	if(ta>tb){
		diff = ( new Date("1970-1-1 " + ta) - new Date("1970-1-1 " + tb) ) / 1000 / 60 ; 
		diff = Math.round(diff);
	} else { diff=0;}
	$('#mu-'+i).val(diff);
}


</script>








