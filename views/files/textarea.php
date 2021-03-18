<style>
textarea{  }
</style>



<form method="POST"  >

<textarea rows=50 cols=100 >
<?php pr($file); ?>
</textarea>




<p>
	<input type="submit" name="submit" value="Save"   />
	<button> <a class="no-underline black" href='<?php echo URL.'files/index'; ?>' >Cancel</a> </button>
	
</p>

</form>

