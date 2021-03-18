<h3>
	Ajax Poster from PHP | <?php $this->shovel('homelinks'); ?>
	
	
	
</h3>

<?php 

pr($_SESSION['q']);

?>


<button onclick="testPoster();" >js testPoster</button>


<script>

var gurl="http://<?php echo GURL; ?>";

function testPoster(){
	var vurl = gurl+'/ajax/xphp.php';	
	var task="testPoster";
	var pdata='task='+task+'&poster=js-php';
	
	$.ajax({
		url:vurl,type:"POST",data:pdata,async:true,
		success: function() { 
			window.location=gurl+'/php/js';
		}		  

    });				

	
	
}	/* fxn */


</script>
