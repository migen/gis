<?php 

// pr($data);
// $bs=2015;



?>


<h5>
	Edit Student Years
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'students/filter'; ?>">Filter</a>
	<?php if($scid): ?>
		| <a href='<?php echo URL."studyears/view/$scid"; ?>'>View</a>
	<?php endif; ?>
	

<?php 
	$d['sy']=$sy;$d['repage']="students/links/$scid";
	$this->shovel('sy_selector',$d); 
?>	

	
</h5>

<?php if($scid): ?>
<table class="gis-table-bordered" >
	<tr>
		<td><?php echo $row['code']; ?></td>
		<td><?php echo $row['name']; ?></td>	
		<td><?php echo $row['classroom']; ?> | #<?php echo $row['crid']; ?></td>	
	</tr>
</table>
<?php endif; ?>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>


<div id="names" >names</div>


<?php if($scid): ?>


<form method="POST" >
<h4>Student</h4>

<table class="gis-table-bordered table-fx" >
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['code']; ?></td></tr>
<tr><th>Beginning SY</th><td><input name="post[begsy]" value="<?php echo $row['begsy']; ?>" type="number" /></td></tr>
<tr><th>Ending SY</th><td><input name="post[endsy]" id="endsy" value="<?php echo $row['endsy']; ?>" type="number" /></td></tr>
<tr><td colspan="2" ><input type="submit" name="submit" value="Save" /></td></tr>
</table>

</form>


<?php endif; ?>


<div class="clear ht50" ></div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits=20;


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/studyears/edit/'+ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
