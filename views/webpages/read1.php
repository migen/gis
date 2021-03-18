<?php


?>


<?php if($is_hidden): ?>
	<h5 id="tracetext" class="b u" onclick="tracepassThis();" >Password</h5>
	<p><?php $this->shovel('hdpdiv'); ?></p>
<?php endif; ?>

<!----------------------------------------------------------------------------------->

<div class="<?php echo ($is_hidden)? 'hd':null; ?>" >	<!-- page -->
<h2><?php echo $wp['name']; ?>  	
	<?php if($suid == $wp['contact_id']): ?> 
		<span class="screen" > | <a href="<?php echo URL; ?>webpages/edit/<?php echo $wp['alias']; ?>">Edit</a></span>
	<?php endif; ?>
</h2>




<div class='page'>
<?php echo $wp['body']; ?>
</div>


</div>	<!-- page -->

<script>

var gurl = "http://<?php echo GURL; ?>";
var hdpass 	= "<?php echo MD5($wp['hdpass']); ?>";



$(function(){
	hd();
	$('#hdpdiv').hide();

})


function tracepassThis(){
	$('#tracetext').hide();
	tracepass();
}

</script>