<?php 

?>


<h5>
	Library Attendance (<?php echo $_SESSION['today']; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."librarians/patrons"; ?>' >Report</a>
	| <a href='<?php echo URL."librarians/recount/".$_SESSION['today']; ?>' >Recount</a>
	
</h5>


<h5>
Number of Visitors
	<span style="background-color:#ccc;padding:6px 20px;" >
		<?php echo $num_visitors; ?></span> 
</h5>


<form method="POST" >
<tr>
	<th>ID Number</th>
	<td><input autofocus name="studcode"  /></td>	
</tr>

<tr><th colspan="2" >
	<input type="submit" name="submit" value="Login"  />
</th></tr>


</form>


<script>

$(function(){

})

setTimeout(function(){
   window.location.reload(1);
}, 1500000);	/* 25minx60x1000 */

</script>