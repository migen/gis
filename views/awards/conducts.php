<style>

div.award {
	color:red; 
	border:1px solid blue;
}	/* award */

</style>

<h5 class="screen" >
	Conducts
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<?php for($i=0;$i<$count;$i++): ?>
	<div class="award" >

		<h5><?php echo $rows[$i]['student']; ?></h5>

	</div>

	<div class="pagebreak" ></div>

<?php endfor; ?>
	