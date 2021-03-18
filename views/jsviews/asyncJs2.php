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



(async() => {
	async function foo(){
		return $.ajax({
			url: '/gis/js/abc',
			success: function(response){
				return response;
			}
			
		})					
	}
	
	var result = await foo();
	
	console.log(result);
	console.log('xxxxxxxxxxxxxx');
	
})();




	





</script>


