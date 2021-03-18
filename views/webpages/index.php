
<h5>Webpages

<?php if(loggedin()): ?>
	| <a href="<?php echo URL.'webpages/add';  ?>" >Add</a>
<?php endif; ?>



<?php 
$suid = $user['ucid'];

?>

</h5>

<!------------------------------------------------------------------------------->


<form method='GET' >
	<input class="vc150 pdl05" name="name"  />
	<input type="hidden" name="page" value="1"  />
	<input type='submit' name='submit' value='Search'>
</form>

<!------------------------------------------------------------------------------->

<?php for($i=0;$i<$num_wp;$i++): ?>
<p>	<a href="<?php echo URL.$wp[$i]['alias']; ?>"  ><?php echo $wp[$i]['name']; ?></a>
	<?php if(($user['role_id']==RMIS) || ($wp[$i]['contact_id']==$suid)): ?>
	 &nbsp; <a href="<?php echo URL.'webpages/edit/'.$wp[$i]['alias']; ?>" > Edit </a>
	 | <a onclick="return confirm('Warning! Cannot Undo Delete!');" href="<?php echo URL.'webpages/delete/'.$wp[$i]['id']; ?>" > Delete </a>
	<?php endif; ?>
</p>
<?php endfor; ?>

<p>
	<!-- pagination -->
	<?php  if(isset($num_pages) && $num_pages){ echo $data['pages']; } ?>
</p>
