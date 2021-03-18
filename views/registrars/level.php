<?php 
$this_year = $_SESSION['sy'];
$next_year = $this_year + 1;

?>

<h5>
	<a href="<?php echo URL.'registrars'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>

<h5><?php echo isset($data['level'][0]['level'])?  $data['level'][0]['level'] : null; ?></h5>

<?php 


// pr($data);

// ================= DEFINE VARS ====================
$printVars = 'dpi=96&__format=pdf&__pageflow=0&__overwrite=false'; 
// level_id,section_id,qtr,sy
$sy = $_SESSION['sy'];


// $f = if($quar)

// pr($data);
?>

<table class="gis-table-bordered table-fx ">
<tr class='bg-blue2'>
	<th class="vc50" >#</th>
	<th class="vc100" >Section</th>
	<th class="vc100" >Profiles</th>
	<th class="vc100" >Promotions</th>

</tr>

<?php $i=1; ?>
<?php foreach($data['level'] AS $row): ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['section']; ?></td>
	<td class="vc100" >
		<a href="<?php echo URL.'registrars/profiles/'.$row['crid']; ?>">Manage</a> 
	</td>	
	<td class="vc150" >
		<a href="<?php echo URL.'registrars/promotions/'.$row['crid'].DS.$this_year.DS.'1'; ?>">Promote</a> | 
		<a href="<?php echo URL.'registrars/classlist/'.$row['crid'].DS.$this_year.DS.'1'; ?>">Classlist</a> 
	</td>	
	

</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>