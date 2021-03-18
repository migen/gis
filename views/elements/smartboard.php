

<?php 
	$width = isset($data['width'])? $data['width']:'10';
	
	// pr($data);

?>

<div class="smartboard" > 
	<button onclick="smartPaste('srcbox');return false;"> Paste Values </button>
	<br />
	<br />
	<textarea id="srcbox" rows="20" cols="<?php echo $width; ?>"  ></textarea>
</div>	<!-- valuesFromExcel -->
