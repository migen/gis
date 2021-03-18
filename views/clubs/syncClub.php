<h5>
	Sync
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/syncClubScores/'.$club_id; ?>" >SyncScores</a>
	| <a href="<?php echo URL.'clubs/syncClubGrades/'.$club_id; ?>" >SyncGrades</a>
	| <a href="<?php echo URL.'clubs/purgeClubGrades/'.$club_id; ?>" >PurgeGrades</a>
	| <a href="<?php echo URL.'clubs/updateClubGrades/'.$club_id; ?>" >UpdateGrades</a>
	
</h5>