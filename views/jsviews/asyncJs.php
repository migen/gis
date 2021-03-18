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
const url2='https://jsonplaceholder.typicode.com/todos/1';


 
(function(){
	
	// loopSequence();	// 1
	// promiseOne(url5);	// 2

	var x = promiseOne(url5);
	alert(x);

	
})();





function promiseOne(url){
	const promise = fetch(url);
	var x;
	promise
		.then(res => res.json())
		.then(data => data.name)
		.catch(err => console.log(err))
	
}






function loopSequence(){
	console.log(`L1: aaa`);	
	setTimeout(_ => console.log(`L2: bbb`));
	Promise.resolve().then(() => console.log(`L3: ccc`));
	console.log(`L4: ddd`);		
}



</script>


