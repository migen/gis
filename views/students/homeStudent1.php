<h5>
	GIS Student Portal | <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="u" >SHD</span>
	
	
</h5>


<?php 




?>



<table class="studhome accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('studhome');" >Student</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/links"; ?>' >Links</a>
		<?php endif; ?>
	</th></tr>
	<tr><td><a href='<?php echo URL."portals/pass"; ?>' >Change Password</a></td></tr>
	<tr><td><a href='<?php echo URL."students/ensumm"; ?>' >Enrollment Summary</a></td></tr>
	<tr><td><a href='<?php echo URL."students/datasheet"; ?>' >Datasheet</a></td></tr>
<?php if($user_is_student): ?>
	<?php 
		$rcard_ctlr=($level_id<14)? 'rcards':'srcards'; 
		$rcget=$_SESSION['settings']['rcard_get'];
	?>
	<?php if($level_id<14): ?>
		<tr><td><a href='<?php echo URL."rcards/scid/$scid/$sy/$qtr?{$rcget}&tpl=$dept_id"; ?>' >Report Card<?php echo $sy; ?></a></td></tr>
	<?php else: ?>
		<?php 
			$half=($qtr<3)? 1:2;		
			$both=$_SESSION['settings']['srcard_both'];			
		?>
		<tr><td><a href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?{$rcget}&both=$both"; ?>' >SHS Report Card<?php echo $sy; ?></a></td></tr>
	<?php endif; ?>
	
	
<?php else: ?>
	<tr><td><a href='<?php echo URL."students/enrollment/$scid"; ?>' >Enrollment</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/sectioner/$scid"; ?>' >Sectioner</a>
		<?php endif; ?>	
	</td></tr>
	<tr><td>
		<?php if($srid==RMIS): ?>
			<a href='<?php echo URL."students/reps"; ?>' >Reps</a>
		<?php endif; ?>	
	</td></tr>
	
	
<?php endif; ?>
	<tr><td>&nbsp;</td></tr>
	
</table>


