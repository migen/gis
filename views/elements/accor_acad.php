<?php 
	$user = $_SESSION['user'];

	
?>


<table class="acad accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('acad');" >Academics</th></tr>
<tr><th class="vc250" >
	<a href="<?php echo URL.'cir/index'; ?>" >Class Index Reports (CIR)</a>
	| <a href="<?php echo URL.'lir'; ?>" ><span class="b" >LIR</span></a>
</th></tr>
<tr><th><a href="<?php echo URL.'students/links'; ?>" >Find Student</a></th></tr>
<tr><th><a href="<?php echo URL.'passwords/reset'; ?>" >Reset Pass</a></th></tr>

<?php if($_SESSION['settings']['trsgrades']==1): ?>
	<tr><td><a class="" href="<?php echo URL.'trs/tir'; ?>" >Trs Index (TIR)</a></td></tr>
<?php endif; ?>
<tr><th><a href="<?php echo URL.'acad/suco'; ?>" >SACS (Records)</a>
	| <a href="<?php echo URL.'sac/sacs/2'; ?>" >Setup</a>
</th></tr>


<tr><td> 
<select class="vc200" onchange="jsredirect('mca/locking/'+this.value+'/'+sy+'/'+qtr);" >
	<option value="0">Advisories & Courses</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>



<tr><td> 
<select class="vc200" onchange="jsredirect('mcr/view/'+this.value+'/'+sy+'/'+qtr);" >
	<option value="0"> MCR </option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>

<?php if($_SESSION['settings']['has_axis']): ?>
	<tr><th class="center" >&nbsp;---</th></tr>
	<tr><th><a href="<?php echo URL.'enrollment/report'; ?>" >Enrollment Report</a>
	</th></tr>
<?php endif; ?>


<tr><th class="center" > --- Settings --- </th></tr>

<tr><th>
	  <a href="<?php echo URL.'courses/settings/4'; ?>" >Courses</a>
	| <a href="<?php echo URL.'components/view/4'; ?>" >Components</a>
	| <a href="<?php echo URL.'acad/locking'; ?>" >Locking</a>	
</th></tr>
<tr><th></th></tr>

</table>

