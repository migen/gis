<?php 
	
	$dbo=PDBO; 

?>

<table class="faves accordion gis-table-bordered table-altrow" >
<tr><th class="accorHeadrow" onclick="accordionTable('faves');" >MIS Faves</th></tr>

<tr><td>
	<a class="b" href='<?php echo URL."notes"; ?>' >Notes</a>
	| <a class="b" href='<?php echo URL."files/edit/version"; ?>' >Version</a>	
	| <a class="b" href='<?php echo URL."files/read/cases"; ?>' >Cases</a>	
</td></tr>

<tr><td>
	<a href="<?php echo URL.'codename/one'; ?>" >Code</a>&nbsp;
	<a href="<?php echo URL.'codename/name'; ?>" >Name</a>
	| <a class="b" href='<?php echo URL."syncs/tables".DBYR; ?>' >Sync Tables</a>
</td></tr>

<tr><td>
	<a class="b" href="<?php echo URL.'passwords/resets'; ?>" >ResetPass</a>
	| <a class="b" href="<?php echo URL.'students/reps'; ?>" >Representatives</a>
</td></tr>


<tr><td><a class="b" href="<?php echo URL.'cir'; ?>" >*Class Index Report ( C I R )</a></td></tr>
<tr><td><a class="b" href="<?php echo URL.'lir'; ?>" >*LEVEL Index Report ( L I R )</a></td></tr>

<tr><td  >
	<a class="b" href="<?php echo URL.'cir/cert'; ?>" >Cert CIR</a>
	| <a class="b" href="<?php echo URL.'cir/index?ext'; ?>" >Ext CIR</a>
	| <a class="" href="<?php echo URL.'cir/index'; ?>" >C I R R</a>	
</td></tr>

<tr><td>
<?php if($_SESSION['settings']['trsgrades']==1): ?>
	<a class="" href="<?php echo URL.'trs/tir'; ?>" >Trs Index (TIR)</a>
<?php endif; ?>	
</td></tr>

<tr><td> 
<select class="vc200" onchange="jsredirect('mca/locking/'+this.value);" >
	<option value="0">Advisories & Courses</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>

<tr><td>
	  <a class="" href="<?php echo URL.'branches'; ?>" >Branches</a>
	| <a class="" href="<?php echo URL.'mgt/contacts'; ?>" >Contacts</a>
	| <a class="" href="<?php echo URL.'contacts'; ?>" >Links</a>
</td></tr>

<tr><td>
	<a class="" href="<?php echo URL.'students/links'; ?>" >Student</a>
	| <a class="" href="<?php echo URL.'mis/teachers'; ?>" >Teac</a>
	| <a class="" href="<?php echo URL.'misc/advisers'; ?>" >Advi</a>
</td></tr>


<tr><td>
		<a href="<?php echo URL.'data/levels'; ?>" >Batch</a>
		| <a href="<?php echo URL.'mis/levels/'.$sy; ?>" > LEVELS </a>		
		| <a href="<?php echo URL.'ibook'; ?>" >iBook</a>		
	</td>
</tr>

<tr><td>
	  <a href="<?php echo URL.'locking/controls/'.DBYR; ?>" >Locking</a>
	| <a href="<?php echo URL.'db/box'; ?>" >Gisbox</a>
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'links'; ?>" >Links</a>
	| <a href="<?php echo URL.'clearance/one'; ?>" >Clearance</a>
	| <a href="<?php echo WURL.'gogo'; ?>" >Gogo</a>
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'scores/filter/'.DBYR.'/'.$_SESSION['qtr']; ?>" >Scores Filter</a>
</td></tr>

<tr><td>&nbsp;</td></tr>


</table>




