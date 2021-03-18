<h3>

	Ajax Promise 2
	


</h3>


<script type="text/javascript" src='<?php echo URL."views/js/jsmin351.js"; ?>' ></script>

<script>


$(function(){

	
	
})	/* fxn */


let p = new Promise(function(resolve, reject) {
  let a = 1+1
  if(a==2){
	  resolve('sum success');
  } else {
	  reject('sum failed');
  }
  
  
});

p.then(
  result => alert(result), 
  error => alert(error) 
);






</script>

