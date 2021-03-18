

<h5>
	GSET (GIS Setup)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset/syncboard'; ?>" >Syncboard</a>
		
</h5>

<div class="third" >
	<?php $incs = SITE."views/elements/accor_gset.php";include_once($incs); ?><br />
	<?php $incs = SITE."views/elements/accor_syncboard.php";include_once($incs); ?>

</div>
<div class="third" >
	<?php $incs = SITE."views/elements/accor_axis_gset.php";include_once($incs); ?>
	<?php $incs = SITE."views/elements/accor_batch.php";include_once($incs); ?>
	
</div>
<div class="third" ><?php $incs = SITE."views/elements/accor_axis.php";include_once($incs); ?></div>
<div class="third" ><?php $incs = SITE."views/elements/accor_invis.php";include_once($incs); ?></div>



