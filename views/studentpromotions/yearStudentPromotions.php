<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	$dbclassrooms="{$dbg}.05_classrooms";
	
	// pr($data);
	
	

?>
<h3>
	Student Promotion | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."studentpromotions/year"; ?>' >Clear</a>


</h3>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,5);return false;' />
		
	</td></tr>
	
</table></p>

<div id="names" >names</div>

<?php if($scid): ?>
<form method="POST">
	<table class="gis-table-bordered" >
		<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
		<tr><th>Student</th><td><?php echo $row['studname']; ?></td></tr>
		<tr><th>Classroom</th><td><?php echo $row['classroom']; ?></td></tr>
		<tr><th>Next SY</th><td><?php echo $row['nextclassroom']; ?></td></tr>
		<tr><th>Promoted</th><td>
			<select name="is_promoted" class="full" >
				<option value=1 <?php echo $row['is_promoted']? 'selected':NULL; ?> >Promoted</option>
				<option value=0 <?php echo ($row['is_promoted']!=1)? 'selected':NULL; ?> >Retained</option>
			</select>
		</td></tr>
		<tr>
			<td colspan=2><input type="submit" name="submit" value="Save" /></td>
		</tr>
	</table>
</form>
<?php endif; ?>



<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/studentpromotions/year/"+id+"/"+sy;
	window.location=url;
}









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

