<style>
div{ border:1px solid white;margin:auto;padding:auto; }
div.attd th,div.attd td{ font-size:1.2em;}
#container{color:#000;width:80%;}
#attdtxt{ font-size:1.6em;}


</style>

<?php 

	// pr($_SESSION['ip']);
	$person=isset($_SESSION['attdrow'])? $_SESSION['attdrow']:NULL;
	// $deptcode=getDeptcode($contact['lvl']);
	// pr($subdepts);
	

?>


<h5>
	DTR  (<?php echo $_SESSION['today']; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		


</h5>


<div id="container" class="" >


<div class="attd" style="width:50%;"  >

<form method="POST" >




<?php $page="DTR Attendance Counter"; 
$inc = SITE.'views/elements/letterhead_only.php';include($inc); ?>

<table class="gis-table-bordered table-fx" >
<tr>
	<th colspan="2"  ><input class="center vc300" type="text" id="time" name="time"
		style="font-size:1.6em;border:none;" /></th>
</tr>


<tr>
	<th>ID</th>
	<td><input autofocus name="studcode" class="full"  /></td>		
</tr>

<tr><th colspan="2" class="center" >
	<input style="font-size:1.2em;" type="submit" name="submit" value="Login"  />
</th></tr>
</table>
</form>
</div>

<div class="clear" ></div>

<?php if(isset($_SESSION['attdrow'])): ?>
<div id="pix" >

<table class="nogis-table-bordered" >
<?php $photo=isset($_SESSION['attdrow']['photo'])?$_SESSION['attdrow']['photo']:NULL; ?>
	
<tr>
<td><img src="data:image/jpeg;base64,<?= base64_encode($photo) ?>" width="240" border="0" /></td>

<td>
<div id="attdtxt" >
	<div><?php echo $person['code']; ?></div>
	<div><?php echo $person['name'].' #'.$person['ucid']; ?></div>
	<div><?php echo $person['classroom']; ?></div>
	<div class="brown" ><?php echo $_SESSION['attdrow']['message']; ?></div>
</div>	<!-- attdtxt-->

</td>

</tr>
</table>




</div>	<!-- pix -->
<?php endif; ?>

</div>	<!-- container -->

<script>

$(function(){
	startTime();
	shd();
})


function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    var time = h + ":" + m + ":" + s;
	$("#time").val(time);
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}


setTimeout(function(){
   window.location.reload(1);
}, 1500000);	/* 25minx60x1000 */

</script>