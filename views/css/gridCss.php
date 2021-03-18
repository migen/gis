<h5>
	Grid | <?php $this->shovel("homelinks"); ?>
	
</h5>

<style>


div:not(".wrapper"){ border:1px solid black; }
div.wrapper{ border:1px solid blue; }


.wrapper{
	display:grid;
	grid-gap:1em;
	grid-template-columns:repeat(5,1fr);
	min-height:200px;
	
}	/* wrapper */

.box{width:120px;height:100px;border:1px solid black;margin:10px;float:left;}

</style>

<?php
	


?>



<div class="wrapperx" >

	<?php for($i=0;$i<20;$i++): ?>	
		<div class="box" >box-<?php echo $i; ?></div>
	<?php endfor; ?>


</div>


<div class="ht50" ></div>
