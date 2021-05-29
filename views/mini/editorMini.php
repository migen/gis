
<h3>

    <?php $this->shovel('homelinks'); ?>
    | <a href="<?php echo URL; ?>mini">Mini</a>
</h3>

<form method="POST"  >


<textarea class="dpl05 pdl05" name="body" rows="20" cols="120"   >
<?php pr($file);  ?>
</textarea>



<br />
<p>
	<input type="submit" name="submit" value="Save"   />
	<button> <a class="no-underline black" href='<?php echo URL.'files/index'; ?>' >Cancel</a> </button>
	
</p>

</form>

