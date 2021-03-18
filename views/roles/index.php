<?php 
	// pr($data);

?>


<!-- ============================================================== -->

<?php 

// pr($_SERVER); for home link,used by registrar and teacher
$home = $_SESSION['home']; 			

?>

<h5>

	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					


</h5>

<!-- ============================================================== -->
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<td> # </td>
	<td> Role </td>
</tr>
<?php for($i=0;$i<$num_roles;$i++): ?>
<tr>
	<td> <?php echo $i+1; ?> </td>
	<td> <?php echo $roles[$i]['name']; ?> </td>
		 
</tr>
<?php endfor; ?>

</table>