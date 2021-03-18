<style>


</style>

<?php 

	// pr($data);
	// $this->shovel('registration');
	
?>




<h5>
	Add Employee 
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."contacts/index/1/?role=".RMIS; ?>' >Employees</a>
	| <a href='<?php echo URL."setup/students/$sy"; ?>' >New Students</a>	
	| <span class="u" onclick="ilabas('clipboard')" >Smartboard</span>
	| <span class="u" onclick="ilabas('shd')" >TRP</span>

</h5>

<?php $this->shovel('filterbox'); ?>


<p>
<table class="gis-table-bordered table-fx f10" >
<tr class="headrow" ><th>Last</th><th>ID</th><th>ID Number</th><th>Name</th></tr>
<tr><td>Student</td><td><?php echo $laststud['id']; ?></td><td><?php echo $laststud['code']; ?></td><td><?php echo $laststud['name']; ?></td></tr>
<tr><td>Employee</td><td><?php echo $lastempl['id']; ?></td><td><?php echo $lastempl['code']; ?></td><td><?php echo $lastempl['name']; ?></td></tr>
</table>
</p>


<div style="width:80%;float:left;" class=""  >

<form method="POST" >	<!-- add  -->

<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>ID</th>	
<th class="vc100" >
		Title<br />
		<select id="ititle" class=''>	
			<option> Choose </option>
			<?php foreach($titles as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populateTitle('title');" >			
</th>
	<th class="vc300" >Full Name<br /><span class='tf12' >Surname, First Middle</span></th>
	<th class="vc80" >Male<br />
		<select id="imale" class='vc80'>	
			<option value="1" > Yes </option>
			<option value="0" > No </option>				
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('male');" />			
	</th>
	<th class="vc80" >ID <br />Number </th>		
	<th class="vc25 shd" > T </th>
	<th class="vc25 shd" > R</th>
	<th class="vc25 shd" > P</th>

</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr class="rc" >
	<?php $pcid+=1; ?>
	<td><input class="vc50" id="pcid<?php echo $i; ?>" name="contacts[<?php echo $i; ?>][pcid]" value="<?php echo $pcid; ?>" /></td>
			
	<td>
		<select class="title" onchange="xgetPriv(this.value,this.id)" id="<?php echo $i; ?>" name="contacts[<?php echo $i; ?>][tid]" >
			<option>Choose One</option>
			<?php foreach($titles AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name'].' R'.$sel['role_id'].'-P'.$sel['privilege_id']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
	
	<td><input id="name<?php echo $i; ?>" class="pdl05 full" type="text" name="contacts[<?php echo $i; ?>][fullname]" 
		placeholder="Surname, First Middle" /></td>
	<td><select id="gender<?php echo $i; ?>" class="vc80 pdl05 male" name="contacts[<?php echo $i; ?>][is_male]"  >
		<option value="1"  >Yes</option> <option value="0"  >No</option> </select></td>	
	
	<?php 
		$num = $lastnum+1+$i;
		$prefix = strtoupper(VCFOLDER);
		$code = setCode($num,$sy,$prefix,$_SESSION['settings']['code_delimeter']);			
	?>
	
	<td><input id="login<?php echo $i; ?>" class="pdl05 vc120" type="text" name="contacts[<?php echo $i; ?>][login]" 
		value="<?php echo $code; ?>" onchange="xcheckLogin(<?php echo $i; ?>);return false;"  />
		<button onclick="xcheckLogin(<?php echo $i; ?>);return false;" > Check </button>   	
	</td>
	
	
	<td class="shd" ><input id="tid-<?php echo $i; ?>" class="pdl05 vc25" type="text" name="contacts[<?php echo $i; ?>][title]" readonly /></td>
	<td class="shd" ><input id="role-<?php echo $i; ?>" class="pdl05 vc25" type="text" name="contacts[<?php echo $i; ?>][role]" readonly /></td>
	<td class="shd" ><input id="priv-<?php echo $i; ?>" class="pdl05 vc25" type="text" name="contacts[<?php echo $i; ?>][priv]" readonly /></td>

	
	
</tr>


<?php endfor; ?>			
</table>
<br />
<p>
	<input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Add" /> 
	&nbsp; <a href="<?php echo URL.'mis'; ?>"><button>Cancel</button></a>
</p>

</form> <!-- add -->


<?php $this->shovel('numrows'); ?>

<div class=" hd vc200" id="names" > names </div>

</div>



<!------------------------------------------------------------------------>

<div style="width:18%;float:left;height:100px;" ></div>

<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="name" >Name</option>
	<option value="gender" >Gender</option>
	<option value="login" >ID Number</option>
	<option value="pcid" >PCID</option>
	<option value="remarks" >Remarks</option>
</select>
</p>
<?php $d['width'] = '40'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>

<div class="clear ht100" >&nbsp;</div>


<!------------------------------------------------------------------------>

<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	hd();
	shd();
	// rc('rc');
	itago('clipboard');
	nextViaEnter();
	$('html').live('click',function(){
		$('#names').hide();
	});

	
})


function rc(cls){
	var x;
	$('.'+cls).each(function(){
		x = this.rowIndex;
		$(this).find("td:first").text(x);
	});
}


function xcheckLogin(i){

var login = $('#login'+i).val();
var vurl 	= gurl + '/ajax/xcontacts.php';	
var task	= "xverifyCode";

// alert(login+", "+vurl+", "+task);
	
$.ajax({
	url: vurl,dataType: "json",type: 'POST',async: true,
	data: 'task='+task+'&code='+login,						
	success: function(s) { 			
		if(s.id){ alert(s.id+' : '+s.name); 
		} else { alert('Available'); } 			
	}		  
});				
	

}	/* fxn */



function xgetPriv(tid,i){
	var vurl=gurl + '/ajax/xcontacts.php';	
	var task="xgetPriv";	
	$.ajax({
		url:vurl,dataType:"json",async:true,
		type:"POST",data:"task="+task+"&tid="+tid,						
		success: function(s) { 					
			$('#tid-'+i).val(s.tid);
			$('#role-'+i).val(s.roleid);
			$('#priv-'+i).val(s.privid);
		}		  
    });				

	
}	/* fxn */




function populateTitle(){
	populateColumn('title');
	setTitle();

}	/* fxn */


function setTitle(){	
	$('.title').each(function(){
		xgetPriv(this.value,this.id);
	})

}	/* fxn */


function redirContact(ucid){
	var url 		= gurl + '/mgt/users/' + ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>