<?php 
	$classrooms=$_SESSION['classrooms'];

?>

<table class="grading accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('grading');" >Grading</th></tr>


<tr><td>
	<a href="<?php echo URL.'cir'; ?>" >Class Index Report (CIR)</a>
	| <a href="<?php echo URL.'lir'; ?>" >LIR</a>
</td></tr>

<tr><td>
	<a href="<?php echo URL.'ranks'; ?>" >Rankings</a>
	| <a href="<?php echo URL.'transcripts/scid'; ?>" >Transcript</a>
</td></tr>



<?php if($_SESSION['settings']['trsgrades']==1): ?>
<tr><td>
<select class="vc200" onchange="jsredirect('trs/matrix/'+this.value+'/'+sy+'/'+qtr);" >
	<option value="0">Traits Matrix</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> 
</td></tr>
<?php endif; ?>

<?php if($_SESSION['settings']['trsgrades']==1): ?>
	<tr><td>
		<a class="" href="<?php echo URL.'trs/tir'; ?>" >Trs Index (TIR)</a>
	</td></tr>
<?php endif; ?>	



<tr><td>
	  <a href="<?php echo URL.'clubs/all'; ?>" >Clubs</a>
	| <a href="<?php echo URL.'foundation'; ?>" >Foundation</a>
	| <a href="<?php echo URL.'shs'; ?>" >SHS</a>

</td></tr>







<tr><td>&nbsp;</td></tr>
</table>


