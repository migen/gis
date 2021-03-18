<h3>

	Ajax Promise 5
	


</h3>


<script type="text/javascript" src='<?php echo URL."views/js/jsmin351.js"; ?>' ></script>

<script>


var data;
var err;
var apiData='some data';


function getData(){
	data=apiData;
	if(data===''){
		err='error getting data';
	}
	return then(data,err);
	
}

function then(data,err){
	setTimeout(function(){
		if(err !== '' && err !== undefined){
			console.log('may mali - ',err);
		} else {
			console.log('balik data - ',data);
		}
		console.log('finished code.');
		
	},1000)
	
}	/* fxn */

getData();





</script>

