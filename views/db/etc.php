<?php 


?>



<h5>
	ETC Box
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	
</h5>


<p>$_GET['sch']</p>


<?php 
if(isset($_GET['debug'])){ pr($dir); }

?>

<!------------------------------------------------------------------------------------------------------------>

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="vc200" >SQL Files</th>

</tr>

<?php $i=1; ?>
<?php foreach($files AS $row): ?>
<?php 
	$file = rtrim($row,'.php');
?>

<tr>
<td><?php echo $i; ?></td>
<td><a href='<?php echo WURL."data/$moid/$file"; ?>' ><?php echo $file; ?></a></td> <!-- target="_blank" -->
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>