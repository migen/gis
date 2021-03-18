<?php 

$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			

?>


<form method="post">

<h5>Log Attendance


<?php if(($home=='students') && $_SESSION['loggedin']): ?>
	<?php $controller = ($_SESSION['user']['role_id']==5)? 'mis':'students';  ?>
	| <a href="<?php echo URL.$controller; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
<?php endif; ?>


</h5>

<table class="gis-table-bordered table-fx"  >
<tr><td><label>Classroom</label></td><td>
<select name="crid" >
<option>Choose One</option>
<?php foreach($classrooms AS $sel): ?>
<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name'];  ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><td><label>Student</label></td><td>
<select id="scid" name="scid" >
</select>
</td></tr>

<tr><td><label>Date</label></td><td><input class="pdl05 juice" type='date' name='date' AutoFocus /></td></tr>

<tr><td><label>P/T</label></td><td>
<input id="pre" type="checkbox" name="pre" value="1"  />Present<br />
<input id="tar" type="checkbox" name="tar" value="1"  />Tardy
</td></tr>
<tr><td colspan='2'><input type='submit' name='submit' value='Go'></td></tr>



</table>
</form>

<!-------------------------------------------------------------------------------------------------------->


<script>

$(function(){

$(".juice").datepicker({
	dateFormat:"yy-mm-dd"
});

// alert(11);


});



</script>