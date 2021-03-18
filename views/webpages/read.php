<script>

var gurl = "http://<?php echo GURL; ?>";
var alias = "<?php echo $alias; ?>";
var hdpass 	= "<?php echo MD5($wp['hdpass']); ?>";



$(function(){
	hd();
	$('#uhdp').focus();
	

})



function gateAuth(){
	var ctp = $('#uhdp').val();
	var url = gurl+"/alias";
	$('#uhdp').val('');
	$('#hdpdiv').hide();			
	var hp = CryptoJS.MD5(ctp);
	if(hdpass==hp){ 
		// location.reload();
		// $.post(URL,data,callback);
		alert(url);
		$('.hd').show(); 
		
		
	} 	
	return false;
	
}	


</script>

<!------------------------------------------------------------------------->

<?php





?>


<?php if($is_hidden): ?>
<form method="POST" >
	<input name="hdpass" />	
	<input type="submit" name="submit" value="Submit" />
</form>	
<?php endif; ?>

<!----------------------------------------------------------------------------------->


<?php if(!$is_hidden || $_SESSION['show']): ?>	<!-- page -->
	<h2><?php echo $wp['name']; ?>  	
		<?php if($suid == $wp['contact_id']): ?> 
			<span class="screen" > | <a href="<?php echo URL; ?>webpages/edit/<?php echo $wp['alias']; ?>">Edit</a></span>
		<?php endif; ?>
	</h2>

	<div class='page'>
	<?php echo $wp['body']; ?>
	</div>

<?php endif; ?>	<!-- page -->

