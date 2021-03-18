<h3>
	Student Edit Enrollment | <?php $this->shovel('homelinks'); ?>
	
	
</h3>


<?php 



?>

<?php if($is_admin): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
<?php endif; ?>


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>Student</th>
	<td><?php echo $row['student']; ?></td>
</tr>
<tr>
	<th>Classroom</th>
	<td><select name="crid" >
		<?php foreach($classrooms AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['crid'])? 'selected':NULL; ?>
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select></td>
</tr></tr>




</table>
</form>



<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/students/enrollment/'+ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

