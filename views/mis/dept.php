<h5>Department
	| <a href="<?php echo URL; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

</h5>

<?php 

	// pr($contact);
	// pr($_SESSION['q']);
	
	
?>


<!----------------------------------------------------------------------->
<form method="POST" >
<table class="gis-table-bordered"  >
<tr><th>Name</th><td class="vc250" ><?php echo $contact['name']; ?></td></tr>
<tr><th>Code</th><td><?php echo $contact['code']; ?></td></tr>
<tr><th>Departments</th><td>
	<?php if(isset($contact['is_ps'])): ?>
		<input type="checkbox" name="ps" value="1" <?php echo ($contact['is_ps']==1)? 'checked': NULL; ?>  >PS<br />
		<input type="checkbox" name="gs" value="1" <?php echo ($contact['is_gs']==1)? 'checked': NULL; ?> >GS<br />
		<input type="checkbox" name="hs" value="1" <?php echo ($contact['is_hs']==1)? 'checked': NULL; ?> >HS<br />
	<?php else: ?>
		<input type="checkbox" name="ps" value="1"  >PS<br />
		<input type="checkbox" name="gs" value="1"  >GS<br />
		<input type="checkbox" name="hs" value="1"  >HS<br />
	<?php endif; ?>
		
</td></tr>



</table>

<p><input type="submit" name="submit" value="Submit"   /></p>
</form>




<!----------------------------------------------------------------------->


