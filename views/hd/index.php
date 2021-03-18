

<h5>
	Hd
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

		
</h5>


<p><?php $this->shovel('hdpdiv'); ?></p>

<h4 class="hd" >This is hidden.</h4>


<script>

var hdpass 	= '<?php echo HDPASS; ?>';

$(function(){	
	hd();
	$('#hdpdiv').hide();
	
});


</script>	
