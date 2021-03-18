<h3>
	JS Async | <?php $this->shovel('homelinks'); ?>


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
const url1='gis/js/abc';
const url3='gis/js/def';
const url2='js/abc';
const url5=gurl+'/js/abc';
const url='https://reqres.in/api/users';




(function(){


	const y = doWork(url5);
	alert(y);
	
	
})();



async function doWork(url){

	const x = await fetchReturn(url);
	// alert(x);
	return x;


}	/* fxn */


function fetchPost(url){
	fetch(url,{
		method:'POST',
		headers:{
			'Content-Type':'application/json'
		},
		body: JSON.stringify({
			name:'User One',
		})
	})
		.then(res => res.json())
		.then(data => { return data } )

}



function fetchReturn(url){
	fetch(url)
		.then(res => res.json())
		.then(data => { return data } )

}


function fetchData(url){
	fetch(url)
		.then(res => res.json())
		.then(data =>  console.log(data) )

}


</script>


