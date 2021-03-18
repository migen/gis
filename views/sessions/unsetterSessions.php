<h5>
	Session Unsetter
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'users/session'; ?>" >Session</a>

	<?php pr($data); ?>
	
</h5>



<input type="text" id="key" autofocus />
<input type="submit" name="submit" value="Unset" onclick="axnPage();" />





<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){
	
})


function axnPage(){
	var key=$("#key").val();
	var url=gurl+"/sessions/unsetter/"+key;
	window.location=url;
	
}	/* fxn */

</script>
