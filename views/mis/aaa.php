<h5>
AAA Test



</h5>


<?php 
	
$fxn="world";


	
?>



<script>

var fxn="<?php echo $fxn; ?>";

$(function(){
	// alert(fxn);
	// fxn();
// eval('q'+i)
eval(fxn)();	
	
})

function hello(){ alert('hello'); }
function world(){ alert('world'); }


</script>
