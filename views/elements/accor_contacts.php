
<table class="contacts accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('contacts');" >Contacts</th></tr>

<tr><td>
<select class="vc200" onchange="jsredirect('loads/teacher/'+this.value+'/'+sy);" >
	<option value="0">Teacher Loads </option>
	<?php foreach($teachers AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>



<tr><td style="width:250px;" >
	  <a href="<?php echo URL.'mgt/contacts'; ?>" >Contacts</a> 
	  <a href="<?php echo URL.'contacts'; ?>" >All</a> 
	| <a href="<?php echo URL.'mgt/users/'.$_SESSION['ucid']; ?>" >Users</a> 
	| <a href="<?php echo URL.'misc/user/'.$_SESSION['ucid']; ?>" >User</a> 
	| <a href="<?php echo URL.'mgt/pass'; ?>" >Pass</a> 
</td></tr>
<tr><td>
	 New - <a href="<?php echo URL.'setup/contacts'; ?>" >Employees</a> 
	| <a href="<?php echo URL.'setup/students'; ?>" >Students</a> 
</td></tr>

<tr><td>
	<a class="" href="<?php echo URL.'students/links'; ?>" >Student</a>
  | <a href="<?php echo URL.'misc/teachers?sort=c.name&order=ASC'; ?>" >Teachers</a>
	| <a class="" href="<?php echo URL.'misc/advisers'; ?>" >Advisers</a>
</td></tr>


<tr><td>
	Edit - <a href="<?php echo URL.'codename/one'; ?>" >Code</a>&nbsp;
	<a href="<?php echo URL.'codename/name'; ?>" >Name</a>
</td></tr>

<tr><td>
	<a class="b" href="<?php echo URL.'passwords/resets'; ?>" >ResetPass</a>
	| <a class="b" href="<?php echo URL.'students/reps'; ?>" >Reps</a>
</td></tr>


<tr><td class="" >
	<a href="<?php echo URL.'students/links'; ?>" >Students</a>
	| <a href="<?php echo URL.'scid/promoter'; ?>" >Promoter</a>	
	| <a href="<?php echo URL.'summary/edit'; ?>" >Summary</a>	
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'persons/one'; ?>" >Person</a>
	| <a href="<?php echo URL.'speed/informant'; ?>" > Informant </a>
	| <a href="<?php echo URL.'misc/employing/5'; ?>" >Employees</a> 
</td></tr>
<tr><td>
	<a href="<?php echo URL.'nonteachers?sort=c.name&order=ASC'; ?>" >Empl</a>
  | <a href="<?php echo URL.'registrars/sxns'; ?>" >All Students </a>
</td></tr>
<tr><td>
</td></tr>

<tr><td>
	<a href="<?php echo URL.'misc/multiusers'; ?>" > Multi-Users </a>
	| <a href="<?php echo URL.'misc/multis'; ?>" > Multis </a>
	| <a href="<?php echo URL.'mis/dupliusers'; ?>" >Duplicates</a>	
</td></tr>

<tr><td> 
	Photos
	| <a href="<?php echo URL.'photos/one/'.$_SESSION['pcid']; ?>" >Find</a> 
	
| <select class="vc100" onchange="looper('employees,photos,'+this.value);" >
	<option value="" >Roles</option>
	<option value="" >All</option>
	<?php foreach($roles AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go	
	
</td></tr>


<tr><td>&nbsp;</td></tr>
</table>



