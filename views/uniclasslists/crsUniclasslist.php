<?php 


?>

<h5>
	Courselist <?php echo $course['classroom']; ?>
	| <span onclick="traceshd();" class="b" >ID</span>
	<?php if(!isset($_GET['edit'])): ?>
		| <a href="<?php echo URL.'uniclasslists/crs/'.$crs.'&edit'; ?>" >Edit</a>
	<?php endif; ?>
	
</h5>

<?php 
// pr($course); 

?>

<?php require_once(SITE.'views/college/incs/courseDetails.php'); ?>
<br />



<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >Scid</th>
	<th>Student</th>
</tr>
<tbody id="tbody" >
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</tbody>
</table>


<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	shd();

	
})



</script>

