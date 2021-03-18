<h3>
	Uploads | <?php $this->shovel('homelinks'); ?>

</h3>


<form enctype="multipart/form-data" method="POST">
  <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />

<p><input type="file" name="file_upload" /></p>
<p><input type="text" name="filename" class="pdl05 vc300" placeholder="Optional: rename" /></p>
<p><input type="submit" name="submit" value="Upload" /></p>
  
  
</form>