<h3>
	JS Promises | <?php $this->shovel('homelinks'); ?>


</h3>



<button class="btn btn-primary">Button</button>

<?php 

$dbfeetypes=PDBO.".03_feetypes";
$sy=DBYR;

?>


<script>


const gurl="http://<?php echo GURL; ?>";
const feetype_id=23;
const sy="<?php echo DBYR; ?>";
const dbfeetypes="<?php echo $dbfeetypes; ?>";

window.onload = () => {


	// promiseOne();
	
	var url='/gis/js/def';

	const x = async function postData(url, data = {}) {
	  const response = await fetch(url);
	  return response.json(); 
	}
	
	console.log(x);
	
}	/* onload */










function promiseTwo(){
	const a = getFeetype(feetype_id);
	alert(`gotten name is: ${a}`);
}

function getFeetype(feetype_id){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetRowById";
	var pdata='task='+task+'&id='+feetype_id+'&dbtable='+dbfeetypes+'&sy='+sy;
	
	var a = $.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:false,
		success: function(s) { 
			alert(s.name);		
		}		  

    });				

	// return a.name;
	
}	/* fxn */


function getNameById(){

	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetRowById";
	var pdata='task='+task+'&id='+feetype_id+'&dbtable='+dbfeetypes+'&sy='+sy;
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function(s) { 
			discountPromiseTwo(s.amount,s.percent,s.is_percent); 
		}		  

    });				

	
	
	
}	/* fxn */




function promiseOne(){
	makeRequest('Google').then(response => {
		console.log('Response received');
		return processRequest(response);
	}).then(processedResponse => {
		console.log(processedResponse);
	})
	
}


function makeRequest(location){
	return new Promise((resolve,reject) => {
		console.log(`making request to ${location}`);
		if(location==='Google'){
			resolve('Google says Hi');
		} else {
			reject('We only talk to Google.');
		}
		
	})
}

function processRequest(response){
	return new Promise((resolve,reject) => {
		console.log('procesing response');
		resolve(`extra information + ${response}`);
	})
	
}	/* fxn */






</script>


