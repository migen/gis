<style>
div{ border:1px solid white;margin:auto;padding:auto; }
div.attd th,div.attd td{ font-size:1.2em;}
#container{color:#000;width:60%;}

</style>

<?php 

?>


<h5>
	LSM Library Attendance (<?php echo $_SESSION['today']; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."librarians/patrons"; ?>' >Report</a>
	| <a href='<?php echo URL."librarians/recount/".$_SESSION['today']; ?>' >Recount</a>


	
</h5>

<div id="container" >
<h5>
Number of Visitors
	<span style="background-color:#ccc;padding:6px 20px;" >
		<?php echo $num_visitors; ?></span> 
<br />
<br />
<div style="width:50%;font-size:1.8em;" >Time: <span id="txt" ></span></div>		
</h5>




<div class="third attd" >
<table class="gis-table-bordered" >
<tr><th>Employees</th><td class="vc50" ><?php echo $num_empl; ?></td></tr>
<tr><th>GS</th><td><?php echo $num_gs; ?></td></tr>
<tr><th>HS</th><td><?php echo $num_hs; ?></td></tr>
<tr><th>Total</th><td><?php echo $num_visitors; ?></td></tr>
</table>
</div>


<div class="attd" >
<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>Login ID</th>
	<td><input autofocus name="studcode"  /></td>	
</tr>

<tr><th colspan="2" >
	<input style="font-size:1.4em;" type="submit" name="submit" value="Login"  />
</th></tr>
</table>
</form>
</div>

<div class="clear" ></div>

<?php if(isset($_SESSION['patron'])): ?>
<div id="pix" >

<table class="gis-table-bordered" >
<?php $photo=$_SESSION['patron']['photo']; ?>
	
<tr><td><img src="data:image/jpeg;base64,<?= base64_encode($photo) ?>" width="150" border="0" /></td>
<td><?php 
	$contact=$_SESSION['contact'];
	
?>

<div id="attdtxt" >
	<div><?php echo $contact['name']; ?></div>
	<div><?php echo $contact['code']; ?></div>
	<div><?php echo $contact['deptcode']; ?></div>
	<div><?php echo $contact['classroom']; ?></div>
	<div><?php echo $_SESSION['patron']['message']; ?></div>
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
})


function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s;
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