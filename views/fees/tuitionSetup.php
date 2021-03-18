<h5>
	Tuition Setup - Level 
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'mis/classlist/'.$crid; ?>" >Classlist</a>
	| <a class="u" id="btnExport" >Excel</a> 


</h5>


<?php if($lvlid): ?>	<!-- lvlid -->
	<?php include_once('incs/levelTuition.php'); ?>
<?php else: ?> <!-- lvlid -->
	
	
<table class='gis-table-bordered table-fx'>

<?php if($user['role_id']==RMIS): ?>	<!-- MIS role -->
<?php 
	$d['levels'] = $levels;
	$d['sy'] = $sy;
	$d['home'] = 'fees';	
	$d['axn'] = 'tuitionSetup';	
	$this->shovel('redirect_level',$d); 
?>	
<?php endif; ?>	<!-- MIS role -->	

</table>

	
<?php endif; ?>	<!-- crid -->



<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';

$(function(){
	excel();

})



</script>


