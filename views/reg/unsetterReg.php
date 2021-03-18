<h5>
	Session Unsetter
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'users/session'; ?>" >Session</a>
	
</h5>

<form method="POST" >

<input type="text" name="key"  />
<input type="submit" name="submit" value="Save" />

</form>
