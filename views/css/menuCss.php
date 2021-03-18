<h5>
	Menu | <?php $this->shovel("homelinks"); ?>
	
</h5>

<style>


div:not(".wrapper"){ border:1px solid black; }
div.wrapper{ border:1px solid blue; }


.wrapper{
	display:grid;
	grid-gap:1em;
	grid-template-columns:repeat(5,1fr);
	height:800px;
	
}	/* wrapper */



</style>

<?php
	
function popItems($num=10){
	$content="";
	for($i=0;$i<$num;$i++){
		$content.="<div>Item ".$i."</div>";		
	}
	return $content;
	
}	/* fxn */

?>



<div class="wrapper" >

	<div ><?php $content=popItems(8); echo $content; ?></div>
	<div ><?php $content=popItems(22); echo $content; ?></div>
	<div ><?php $content=popItems(12); echo $content; ?></div>
	<div ><?php $content=popItems(18); echo $content; ?></div>
	<div ><?php $content=popItems(15); echo $content; ?></div>

</div>

<div class="bordered" style="height:80px;"  >

	<?php $content=popItems(22); echo $content; ?>
	<?php $content=popItems(8); echo $content; ?>



</div>


<div class="ht50" ></div>
