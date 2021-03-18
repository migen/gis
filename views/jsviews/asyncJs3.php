<h3>
	JS Async | <?php $this->shovel('homelinks'); ?>


</h3>



<button class="btn btn-primary">Button</button>

<?php 

$dbfeetypes=PDBO.".03_feetypes";
$sy=DBYR;

?>



<script>


var gurl="http://<?php echo GURL; ?>";
const dbfeetypes="<?php echo $dbfeetypes; ?>";
var feerow;
var feetype;
const url5=gurl+'/js/abc';


 
(function(){
	

	// asyncOne();
	// const x = asyncTwo(url5);	

	// alert(asyncOneBee().name);
	// alert(asyncTwoBee(url5).name);
	
	// const y = asyncThree();
	// alert(`y: ${y}`);


	// var x = fetchSync(url5);
	// x.then(res => alert(res.name));
//	console.log(`x: ${x}`);


	fetchSync().then(x => alert(x));


	
})();




function fetchSync(url) {
    fetch(url)
		.then(res => res.json())

	
}

function getFeetype(){
	return feetype;
}


function setFeetype(x){
	feetype=x;
}

function fetchFour(url){
	var result;
    fetch(url)
    .then(res => res.json())
    .then(function(res) {
			// console.log(res);
			// alert(JSON.stringify(res.query));

            var t = res.created;
            var o = res.open;
            var h = res.high;
            var l = res.low;
            var c = res.close;
			
			result = res;
			return result;
        // return {t,o,h,l,c};

    })
    .catch(function(error) {
        console.log(error);
    });    
}




async function asyncThree(){
	const x = await asyncTwoCee();
	return x;
}



async function asyncTwo(url){
	const x = await asyncTwoBee(url);
	console.log(x);	
}



async function asyncTwoCee(){

	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetRowById";
	var pdata='task='+task+'&id=23'+'&dbtable='+dbfeetypes+'&sy=2020';
	
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function(s) { 
			feetype+=s.name;
			// gurl=gurl+"hahaha";
			// alert(gurl);
		}		  

    });				

	
}	/* fxn */

function asyncTwoBee(url){
	return fetch(url)
		.then(res => res.json())
		.then(data => { return data })

}





async function asyncOne(){
	const x = await asyncOneBee();
	alert(x.name);	
}


function asyncOneBee(){
	const person={
		'id':23,
		'name':'Makol',		
	};
	return person;
}



</script>


