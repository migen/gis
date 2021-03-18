
<?php 





?>


<h5>
	Registration | 
	<?php 	$controller = $home; $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."registration/one"; ?>' >Register</a>
	| <span onclick="pclass('id');" >ID</span>

</h5>

<h2 class="brown" >*New Student for SY <?php echo $sy; ?></h2>

<?php 


if(!$dbexists){ echo "<h2 class='brown'>".$sy." database has not been created. <br />
Please contact GIS Service Provider.</h2>"; exit; }

require_once(SITE.'/views/registration/incs/filter_codename.php');


?>



<p>
<table class="gis-table-bordered table-fx f10" >
<tr class="headrow" ><th>Last</th><th>ID</th><th>ID Number</th><th>Name</th></tr>
<tr><td>Student</td><td><?php echo $laststud['id']; ?></td><td><?php echo $laststud['code']; ?></td><td><?php echo $laststud['name']; ?></td>

</tr>
</table>
</p>



<form method="POST" >



<input type="hidden" name="role_id" value="1" />
<input type="hidden" name="privilege_id" value="1" />


<div style="width:900px;float:left;" class=""  >
<h5> New Students 
| <a href='<?php echo URL."setup/students?all"; ?>' >All Classrooms</a>
| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>	

</h5>
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc20" >#</th>
	<th class="vc200" >Full Name</th>
	<th class="vc80" >Is <br />Male<br />
		<input class="pdl05 vc50" id="imale" /><br />	
		<input type="button" value="All" onclick="populateColumn('male');" >										
	</th>
	<th class="vc80" >ID <br />Number
		<br /><input type="button" value="Clear" onclick="clearAll('code');" >		
	</th>
	<th>Verify</th>
	<th class="center" >
		Classroom<br />
		<select id="icr" class='vc150'>	
			<option> Choose </option>
			<?php foreach($classrooms as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateClassrooms('cr');" >
	</th>	
	<th class="id" >Lvl</th>
	<th class="id" >Dept</th>
	<th class="id" >Acid</th>

</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	
	<td><input id="name<?php echo $i; ?>" class="pdl05 full" type="text" name="contacts[<?php echo $i; ?>][fullname]" 
		placeholder="Surname, First Middle" tabindex="2" /></td>
	<td><select id="gender<?php echo $i; ?>" class="vc80 pdl05 male" name="contacts[<?php echo $i; ?>][is_male]"  tabindex="4" > 
		<option value="1"  >Yes</option>
		<option value="0"  >No</option> </select></td>	
		
	<td>
		<?php 
			$num = $lastnum+1+$i;						
			$code = setCode($num,$sy,$prefix,$delimeter,$code_len);	
		?>
	
		<input  id="cd<?php echo $i; ?>" onchange="xverifyContact(<?php echo $i; ?>);return false;" class="pdl05 vc120 code"  
			name="contacts[<?php echo $i; ?>][code]" value="<?php echo $code; ?>" tabindex="6" />
	</td>
	<td><button onclick="xverifyContact(<?php echo $i; ?>);return false;" >Verify</button></td>
	
	<td>
		<select onchange="xcrid(this.value,<?php echo $i; ?>)" id="cr<?php echo $i; ?>" class="cr vc150" 
			name="contacts[<?php echo $i; ?>][crid]" tabindex="8" >
			<option>Choose One</option>
			<?php foreach($classrooms AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>
	<td class="id" ><input id="lvlid<?php echo $i; ?>" class="vc30" type="text" name="contacts[<?php echo $i; ?>][level_id]" readonly /></td>
	<td class="id" ><input id="deptid<?php echo $i; ?>" class="vc30" type="text" name="contacts[<?php echo $i; ?>][department_id]" readonly /></td>
	<td class="id" ><input id="acid<?php echo $i; ?>" class="vc50" type="text" name="contacts[<?php echo $i; ?>][acid]" readonly /></td>

	
</tr>

<?php endfor; ?>			

</table>

<p>
	<input onclick="return confirm('Are you sure?');" type="submit" name="add" value="Add"  />
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>

<p><?php $this->shovel('numrows'); ?></p>
<div class=" hd vc200" id="names" > </div>

</div>
<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="" style="width:200px;float:left;"  >
<p class="smartboard" >
<select id="classbox" >
	<option value="name" >Name</option>
	<option value="gender" >Gender</option>
	<option value="cd" >ID Number</option>
	<option value="cr" >Classroom</option>
</select>
</p>
<?php $this->shovel('smartboard'); ?>
</div>




<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $_SESSION['sy']; ?>';
var limits='20';

$(function(){
	itago('smartboard');
	itago('id');
	nextViaEnter();
	$('html').live('click',function(){
		$('#names').hide();
	});

})

function populateClassrooms(){

	populateColumn('cr');
	setClassrooms();
	

}	/* fxn */

function setClassrooms(){	
	$('.cr').each(function(index){
		xcrid(this.value,index);
	})

}	/* fxn */


function xverifyContact(i){	
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= "xverifyCode";
	var code = $('#cd'+i).val();
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&code='+code,						
		success: function(s) { 			
			if(s.name){ alert(s.id+' : '+s.name); 
			} else { alert('Available'); } 
		}		  
    });				
	
}	/* fxn */


function xcrid(crid,i){	
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "xcrid";
	var crid=$('#cr'+i).val();
		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&crid='+crid,						
		success: function(s) { 			
			$('#lvlid'+i).val(s.level_id);
			$('#deptid'+i).val(s.department_id);
			$('#acid'+i).val(s.acid);
		}		  
    });				
	
}	


function redirContact(ucid){
	var url 		= gurl + '/students/sectioner/' + ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
