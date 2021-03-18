<?php 

pr($data);
// pr($data['user']['level_id']);
$user=$data['user'];
// $srid=$user['srid'];
echo "<hr />";
pr($user);
exit;

$user_is_student=$data['user_is_student'];

if($user_is_student){
	$dept_id=$data['user']['dept_id'];
	$level_id=$data['user']['level_id'];
	
}


?>



<table class="studhome accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('studhome');" >Student</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
		<?php if($srid!=RSTUD): ?>
			| <a href='<?php echo URL."students/links"; ?>' >Links</a>
		<?php endif; ?>
	</th></tr>
	<tr><td><a href='<?php echo URL."portals/pass"; ?>' >Change Password</a></td></tr>
	<tr><td><a href='<?php echo URL."students/ensumm"; ?>' >Enrollment Summary</a></td></tr>
	<tr><td><a href='<?php echo URL."students/datasheet"; ?>' >Datasheet</a></td></tr>
<?php if($data['user_is_student']): ?>
	<?php $rcard_controller=($level_id<14)? 'rcards':'srcards'; ?>

	<tr><td><a href='<?php echo URL."{$rcard_controller}/scid/$ucid/$sy/4?show&tpl=$dept_id"; ?>' >Report Card <?php echo $sy; ?></a></td></tr>
<?php else: ?>
	<tr><td><a href='<?php echo URL."students/enrollment/$ucid"; ?>' >Enrollment</a>
		<?php if($srid!=RSTUD): ?>
			| <a href='<?php echo URL."students/sectioner/$ucid"; ?>' >Sectioner</a>
		<?php endif; ?>	
	</td></tr>
<?php endif; ?>
	<tr><td>&nbsp;</td></tr>
	
</table>


