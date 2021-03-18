<h5>
	Filter Student
	| <a href="<?php echo URL; ?>students">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'students/links'; ?>">Links</a>
	
</h5>


<?php 

include_once('incs/filter_codename.php');
	

?>


<div id="names" >names</div>


<script>

$(function(){
	$('#names').hide();
})

</script>