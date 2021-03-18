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

	
	// fetch(url5)
		// .then(res => res.json())
		// .then((data) => {
			// person = data;
		// });
	
	// alert(person);
	


	
})();


function fetchFive(){

	async function getData(url) {
	  const response = await fetch(url);

	  return response.json();
	}

	const data = await getData(url);

	console.log({ data })	
	
}



function fetchFour(){
	let jsondata;    
	fetch(url5).then(
        function(u){ return u.json();}
      ).then(
        function(json){
          jsondata = json;
        }
      )	
	
	console.log(`jsondata is ${jsondata}`);

	
}


function fetchThree(){
	person = fetch(url5)
		.then(res => res.json())
		.then(data => {
			person = data.name;
			console.log(`person: ${person}`);
		});
	
	
}


function fetchTwo(){
	// res = ['name'=>'MakolEngr Go'];
	fetch(url5)
		.then(res => res.json())
		.then(data => console.log(data.name));
		
}


function fetchOne(){
	
	fetch(url5)
		.then(res => {
			if(res.ok){
				res.json()				
				console.log('res ok');
			} else {
				console.log('res NOT ok');				
			}
		})
		.then(data => console.log(data));
	
	
}


</script>


