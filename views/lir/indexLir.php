<?php 

$is_dual=$_SESSION['settings']['is_dual'];
$prevsy=($sy-1);
$prevsy_code=substr($prevsy,2,2);


?>

<h5>
	Levels (LIR) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'cir'; ?>" >CIR</a>	
	| <?php for($q=1;$q<5;$q++): ?>
		<a href='<?php echo URL."lir/index/$sy/$q"; ?>' >Q<?php echo $q; ?></a> &nbsp; 
	<?php endfor; ?>
	
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Level</th>
	<th>List</th>
	<th>CIR</th>
	<th>Ranks</th>
	<th>Ranks W/<br />Genave</th>
	<th>Honors</th>
	<th>H&C</th>
	<th>Honors<br />Cert</th>
	<th>Best<br />In</th>
	<th>MCA<br />Locks</th>
</tr>
<?php 

// include_once('lir_hybrid.php'); 
if($is_dual){
	include_once('lir_dual.php'); 
} else {
	include_once('lir_single.php'); 
}
	
	
?>

</table>
