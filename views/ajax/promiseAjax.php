<h3>

	Ajax Promise
	


</h3>


<script type="text/javascript" src='<?php echo URL."views/js/jsmin351.js"; ?>' ></script>

<script>


$(function(){

	
	
})	/* fxn */


let promise = new Promise(function(resolve, reject) {
  setTimeout(() => resolve("done!"), 1000);
});

// resolve runs the first function in .then
promise.then(
  result => alert(result), // shows "done!" after 1 second
  error => alert(error) // doesn't run
);



function abc(){
	console.log('abc');
	// return 123;
	
}




</script>

