

<!-------------------------------------------------------------------------------------->

<?php



// pr($classroom);
// pr($students[0]);
// pr($students[0]);



?>

<h5>
	Class List
	| <a href='<?php echo URL."profiles/classroom/$crid/$sy"; ?>'>Profiling</a>		
	
<?php  if(($user['role_id'] == RREG) || ($user['role_id'] == RMIS)): ?>	
		| <a href="<?php echo URL.'sectioning/crid/'.$crid.DS.$sy; ?>">Sectioning</a>		
		| <a href="<?php echo URL.'students/sectioner'; ?>">Sectioner</a>		
		| <a href="<?php echo URL.'setup/students'; ?>">Registration</a>
<?php endif; ?>	
	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 
	
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>



<?php 

// pr($data);
// pr($classroom);




?>

<!-- ========================  page info / user info =================================-->
<table class='gis-table-bordered table-fx'>
<tr><th class="white bg-blue2" >Level - Section</th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>

<?php if($user['role_id'] != RTEAC): ?>
<tr><th class="white bg-blue2" >ID Number</th><td><?php echo $classroom['adviser_code']; ?></td></tr>
<tr><th class="white bg-blue2" >Teacher</th><td><?php echo $classroom['adviser']; ?></td></tr>
<?php 
	$d['classrooms'] = $classrooms;
	$d['sy']		 = $sy;
	$d['axn']		 = 'classlistManager';
	
	$this->shovel('redirect_classroom',$d); 
?>
	
<?php endif; ?>	


</table>

<form method='post' > <!-- for batch edit/delete -->

<!-- =================== BOYS ===================  -->
<h4> Students </h4>
<table class="gis-table-bordered" >

<tr class="headrow" >
<th>&nbsp;</th>
<th class="" >ID</th>
<th>Prnt</th>
<th>Actv</th>
<th>
	<input class="pdl05 vc60" type="text" id="iyear" placeholder="Year" type="number" /><br />	
	<input type="button" value="All" onclick="populateColumn('year');" >			
</th>
<th>Name</th>
<th>Login</th>
<th>Pass</th>
<th>&nbsp;</th>
</tr>


<?php for($i=0;$i<$num_students;$i++): ?>
<?php $active = $students[$i]['is_active']; ?>
<tr class="<?php echo ($active==1)? NULL:'red'; ?>" id="trow<?php echo $i; ?>" >
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $i;?>]" value="<?php echo $students[$i]['id']; ?>" /></td>
	<td><input class="pdl05 vc50" name="contact[<?php echo $i; ?>][id]" value="<?php echo $students[$i]['id']; ?>" readonly /></td>
	<td><input class="pdl05 vc50" name="contact[<?php echo $i; ?>][parent_id]" value="<?php echo $students[$i]['parent_id']; ?>" 
		onclick="xname('dbo','00_contacts',this.value);" ondblclick="xpopname('dbo','00_contacts',this.value);" /></td>

	<td><input class="pdl05 vc30" name="contact[<?php echo $i; ?>][is_active]" value="<?php echo $students[$i]['is_active']; ?>" 	
		type="number" min="0" max="1"	/></td>
	<td><input class="pdl05 vc60 year" type="number" name="contact[<?php echo $i; ?>][year]" value="<?php echo $students[$i]['year']; ?>" /></td>
	<td><input class="pdl05 vc250" name="contact[<?php echo $i; ?>][name]" value="<?php echo $students[$i]['name']; ?>" /></td>
	<td><input class="pdl05 vc100" name="contact[<?php echo $i; ?>][code]" value="<?php echo $students[$i]['student_code']; ?>" /></td>
	<td><input class="pdl05 vc100" name="contact[<?php echo $i; ?>][pass]" value="<?php echo $students[$i]['ctp']; ?>" /></td>
	<td>			
		<button><a onclick="xeditContactCtp(<?php echo $i; ?>);return false;" >Save</a></button>
		<button onclick="deltrow(<?php echo $i; ?>);" >Hide</button>
		&nbsp;&nbsp; 
		<span class="hd" >
			<input ondblclick="xpopname('dbo','00_contacts',this.value);" class="vc50 center" id="idto-<?php echo $i; ?>" value="0"  />
			<button onclick="return ptl(<?php echo $students[$i]['scid'].','.$i; ?>);" >PTL</button>	
		</span>
	</td>		
</tr>

<?php endfor; ?>


</table>


<p class="screen" >	
	<span class="" ><input onclick="return confirm('You sure?');" type='submit' name='save' value='Save All' ></span>
	<button onclick="alert('Password Protected!');return false;" >MANAGE</button>
	<span class="hd" ><input onclick="return confirm('DANGEROUS! Proceed?');" type='submit' name='batch' value='DELETE' ></span>
</p>


</form> <!-- for batch -->



<!-------------------------------------------------------------------------------------->

<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo 'registrars'; ?>';


$(function(){
	hd();
	// alert('refreshed');
	$('#hdpdiv').hide();
	nextViaEnter();
	selectFocused();

})







</script>


