<h3>

	Ajax Promise 4
	


</h3>


<script type="text/javascript" src='<?php echo URL."views/js/jsmin351.js"; ?>' ></script>

<script>


$(function(){

	
	
})	/* fxn */



const p1 = new Promise((resolve,reject) =>{	
	// setTimeout(()=>{alert(1);},1000);
	resolve('sleep Video 1 recorded');
	
})

const p2 = new Promise((resolve,reject) =>{	
	resolve('Video 2 recorded');
	
})



// p1.then((msg)=>{ alert(msg); })

Promise.race([p1,p2]).then((messages)=> {console.log(messages) })


</script>

