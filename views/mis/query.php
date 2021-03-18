<h5>
	Query | <span ondblclick="tracehd();" >HD</span>
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>

<?php 
pr($data);
?>


<?php if(isset($q)): ?>
<p><?php pr($q); ?></p>
<?php endif; ?>

<div class="hd" >
<form method="POST" >
<textarea name="query" rows="10" cols="150" >

</textarea>

<p><input id="btn" onclick="return confirm('Warning! Cannot Undo! Sure?');"  type="submit" name="submit" value="Execute"  /></p>
</form>
</div>



<!------------------------------------------------------------------------------------------------->

<script>

var hdpass 	= '<?php echo HDPASS; ?>';


	$(function(){ 
		$('#hdpdiv').hide();
		// hd(); 				
		$("#btn").click(function(){ this.hide(); })

	})
</script>
