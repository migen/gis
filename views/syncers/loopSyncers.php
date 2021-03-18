<h5>
	<span class='u' ondblclick="tracehd();" >Loop</span>Syncer for Grades
	<span class="hd" >HD</span>
	
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>



<form method="POST" >

<table class="gis-table-bordered table-altrow" >

<tr>
	<th>Ctype</th>
	<td>
		<?php foreach($ctypes AS $sel): ?>
			<input class="" type="radio" name="ctype" 
				value="<?php echo $sel['id']; ?>"><label><?php echo $sel['name']; ?></label><br>				
		<?php endforeach; ?>		
	</td>
</tr>

<tr>
	<th>
		PS & GS Classrooms<br />
		<input type="checkbox" id="chkAlla"  />All
	</th>
	<th>
		HS Classrooms<br />
		<input type="checkbox" id="chkAllb"  />All
	</th>
</tr>

<tr>
<td>
	<?php foreach($gscr AS $sel): ?>
		<input type="checkbox" class="chka" name="classrooms[]" 
			value="<?php echo $sel['id']; ?>"><label><?php echo $sel['name']; ?></label><br>				
	<?php endforeach; ?>
</td>
<td>
	<?php foreach($hscr AS $sel): ?>
		<input class="chkb" type="checkbox" name="classrooms[]" 
			value="<?php echo $sel['id']; ?>"><label><?php echo $sel['name']; ?></label><br>				
	<?php endforeach; ?>
</td>
</tr>


</table>

<p class="sshd" ><input type="submit" name="submit" value="Submit" onclick="return confirm('Warning! Sure?');"  /></p>

</form>

<div class="ht100" ></div>



<!------------------------------------------------->

<?php 
	$hdpass = isset($hdpass)? $hdpass:HDPASS;  
	DEFINE('SECRET',$hdpass); 
	
	
?>


<script>

var gurl = "http://<?php echo HOST.'/'.DOMAIN; ?>";
var hdpass = "<?php echo HDPASS; ?>";
			
$(function(){
	chkAllvar('a');
	chkAllvar('b');
	hd();
	$('#hdpdiv').hide();
})




</script>


