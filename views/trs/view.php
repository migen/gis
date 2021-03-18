<h5>
	Traits View
	<span class="u" ondblclick="tracehd();" >HD</span>
	| <?php echo $cr['name'].' - '.$teacher['name']; ?>	
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."trs/view/$crsid/$tcid"; ?>'>View</a>	
	
</h5>


<p class="brown" >Press "Sync" button below to initialize grades if dashes (-) appear instead of zeroes (0). </p>

<?php 

	$acount = 0;
	$k=0;

?>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<?php foreach($criteria AS $row): ?>
		<th class='center' ><?php echo $row['code'].'<br />('.$row['weight'].')<br />'.$row['cid']; ?>
			<br />			
			<a href="<?php echo URL.'trs/editTrsColumn/'.$crsid.DS.$tcid.DS.$row['cid'].DS.$sy.DS.$qtr; ?>" >Edit</a>
			<span class="hd" ><br /><a href="<?php echo URL.'trs/deleteTrsColumn/'.$crsid.DS.$tcid.DS.$row['cid'].DS.$sy.DS.$qtr; ?>" >Delete</a></span>
		</th>
	<?php endforeach; ?>
</tr>
<?php for($i=0;$i<$numrows;$i++): ?>

<?php 
	$rcount = count($trsgrades[$i]);
	if($rcount!=$numcri){
		$br = buildArray($trsgrades[$i],'criteria_id');
		$ix = array_diff($ar,$br);		
	}	
?>

<?php if(!empty($ix)): ?>
<?php foreach($ix AS $pcri): ?>	
	<input type="hidden" name="posts[<?php echo $k; ?>][scid]" value="<?php echo $students[$i]['scid']; ?>"  />
	<input type="hidden" name="posts[<?php echo $k; ?>][criteria_id]" value="<?php echo $pcri; ?>"  />			
	<?php $k++; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php $ix=null; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['scid']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>

	<?php for($j=0;$j<$numcri;$j++): ?>
		<?php if(isset($trsgrades[$i][$j]['grade'])): $acount+=1; ?> <?php endif; ?>
		<td class="center" ><?php echo (isset($trsgrades[$i][$j]['grade']))? $trsgrades[$i][$j]['grade']:'-'; ?></td>
	
	<?php endfor; ?>	<!-- j for numcri -->
</tr>
<?php endfor; ?>
</table>

<?php if($tcount!=$acount): ?>
	<p><input type="submit" name="sync" value="Sync"  /></p>
<?php endif; ?>
	

</form>




<script>

$(function(){
	hd();

})


</script>

