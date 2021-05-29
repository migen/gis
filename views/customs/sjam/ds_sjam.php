<?php

require_once('datasheet_sjam_model.php');


?>

<div class='screen'>

<h3 class="pagelinks" >
	SJAM Datasheet 
	| <?php $this->shovel('homelinks'); ?>
	<?php if($scid): ?>
		| <a href="<?php echo URL.'students/ds/'.$scid.DS.$sy; ?>" >DS</a>
	<?php endif; ?>

</h3>

<?php 

pr($controls);


?>

</div>

<?php if($srid!=RSTUD): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<script>
		var gurl = "http://<?php echo GURL; ?>";
		var limits='20';
		$(function(){
			selectFocused();
			nextViaEnter();
			$('#names').hide();
			$('html').live('click',function(){ $('#names').hide(); });
			
		})

		function redirContact(scid){
			var url = gurl+'/students/datasheet/'+scid;	
			window.location = url;		
		}
		
	</script>
	<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<?php endif; ?>	<!-- if employee -->

<?php if(!$scid){ pr("No scid."); exit; }?>


<style>
	.datasheet-container {
		padding: 50px 25px;
	}

	.datasheet-container .title {
		margin-bottom: 50px;

		font-size: 30px;
		font-weight: 600;
		text-align: center;
		letter-spacing: 4px;
		text-transform: uppercase;
	}

	.datasheet-container .form-content {
		max-width: 950px;
		margin: auto;
	}

	.datasheet-container .form-content .datasheet-form .form-group {
		display: flex;
		flex-direction: row;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group {
		display: flex;
		flex-direction: row;

		margin-right: 15px;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group:last-child {
		margin-right: 0;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .choices {
		display: flex;

		width: 190px;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .title-head {
		margin-bottom: 10px;

		font-size: 1em;
		font-weight: bold;
		text-transform: uppercase;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .label {
		display: block;
		flex: none;

		width: 125px;

		font-size: 1em;
		font-weight: bold;
		text-transform: uppercase;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .label.right-inline {
		width: auto;
		padding-right: 8px;
		padding-left: 10px;

		text-align: right;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control {
		display: block;

		margin-top: -4px;
		margin-right: 8px;
		margin-bottom: 10px;
		padding: 4px;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control.radio {
		margin-top: 2px;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#address {
		width: 500px;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#birthday,
	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#birthplace,
	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#age,
	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#religion,
	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#nationality,
	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#telNumber {
		width: 334px;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .input-control#siblings {
		width: 950px;
	}

	.datasheet-container .form-content .datasheet-form .form-group .input-group .datasheet-btn {
		min-width: 100px;
		padding: 5px 15px;

		font-size: 15px;
		font-weight: 600;
		letter-spacing: 3px;
		text-transform: uppercase;
	}

	.datasheet-container .form-content .datasheet-form .spacer {
		width: 100%;
		height: 15px;
	}

	.datasheet-container .form-content .datasheet-form .spacer-lg {
		width: 100%;
		height: 30px;
	}

	.datasheet-container .form-content .datasheet-form .status {
		display: flex;
		justify-content: flex-end;

		width: 100%;
		margin-left: 13px;
	}

	.datasheet-container .form-content .datasheet-form .status-choices {
		display: flex;
		flex-direction: column;

		margin-bottom: 15px;
	}

	.datasheet-container .form-content .datasheet-form .status-choices label {
		margin-bottom: 5px;
		margin-left: -5px;

		font-weight: bold;
		text-transform: uppercase;
	}

	.datasheet-container .form-content .datasheet-form .status-choices .input-group {
		display: flex;
	}

	.datasheet-container .form-content .datasheet-form .status-choices .input-group .label {
		padding-right: 10px;

		font-weight: 600;
	}

	.datasheet-container .form-content .datasheet-form .status-choices .input-group .input-control {
		padding: 4px;
	}

	.datasheet-container .form-content .datasheet-form .scholarship .input-group {
		margin-right: 10px;
		padding: 5px;

		border: 1px solid #D4D1D1;
	}

	/*# sourceMappingURL=datasheet.css.map */
</style>


	<div class="datasheet-container">
		<div class="title">Datasheet</div>
		<div class="form-content">
			<form class="datasheet-form" action="" method="POST" >			
				<div class="status">
					<div class="status-choices">
						<label class="form-check-label">
							<input type="radio" class="input-control" id="old" name="status" value="old" />Old
						</label>
						<label class="form-check-label">
							<input type="radio" class="input-control" id="new" name="status" value="new" />New
						</label>
						<div class="input-group">
							<div class="label">Last School Attended</div>
							<input class="input-control" id="lsa" name="lsa" value="Last School Attended" />
						</div>
					</div>
				</div>

				<div class="spacer"></div>

				<div class="stude-info">
					<div class="form-group">
						<div class="input-group">
							<div class="label">Last Name</div>
							<input class="input-control" id="lastname" name="lastname" value="<?php echo $last_name; ?>" readonly />
						</div>
						<div class="input-group">
							<div class="label">First Name</div>
							<input class="input-control" id="firstname" name="firstname" value="<?php echo $first_name; ?>" readonly />
						</div>
						<div class="input-group">
							<div class="label">Middle Name</div>
							<input class="input-control" id="middlename" name="middlename" value="<?php echo $middle_name; ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Address</div>
							<input class="input-control" id="address" name="profile[address]" value="<?php echo $address; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Gender</div>
							<div class="choices">
								<input class="input-control radio" type="radio" id="male" name="contact[is_male]" value="<?php echo $is_male; ?>">
								<label for="female">Male</label><br>
								<input class="input-control radio" type="radio" id="female" name="contact[is_male]" 
									value="<?php echo $is_male; ?>">
								<label for="female">Female</label><br>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Birthday</div>
							<input class="input-control" id="birthday" name="profile[birthdate]" value="<?php echo $birthdate; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Birth Place</div>
							<input class="input-control" id="birthplace" name="profile[birthplace]" value="<?php echo $birthplace; ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Age</div>
							<input class="input-control" id="age" name="profile[age]" value="<?php echo $age . ' Years Old';?>" />
						</div>
						<div class="input-group">
							<div class="label">Religion</div>
							<input class="input-control" id="religion" name="profile[religion]" value="<?php echo $religion; ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Nationality</div>
							<input class="input-control" id="nationality" name="profile[nationality]" value="<?php echo $nationality; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Tel. No.</div>
							<input class="input-control" id="telNumber" name="profile[phone]" value="<?php echo $phone?>" />
						</div>
					</div>
				</div>

				<div class="spacer-lg"></div>

				<div class="scholarship">
					<div class="form-group">
						<div class="input-group">
							<div class="label">Employee's Child</div>
							<input class="input-control radio" type="radio" id="yes" name="empChild" value="yes">
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" id="no" name="empChild" value="no">
							<label for="female">No</label><br>
						</div>
						<div class="input-group">
							<div class="label">Esc Grantee</div>
							<input class="input-control radio" type="radio" id="yes" name="escgrantee" value="yes">
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" id="no" name="escgrantee" value="no">
							<label for="female">No</label><br>
						</div>
						<div class="input-group">
							<div class="label">Academic Scholar</div>
							<input class="input-control radio" type="radio" id="yes" name="acadScholar" value="yes">
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" id="no" name="acadScholar" value="no">
							<label for="female">No</label><br>
						</div>
						<div class="input-group">
							<div class="label">PTA Scholar</div>
							<input class="input-control radio" type="radio" id="yes" name="ptaScholar" value="yes">
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" id="no" name="ptaScholar" value="no">
							<label for="female">No</label><br>
						</div>
					</div>
				</div>

				<div class="spacer-lg"></div>

				<div class="father-info">
					<div class="form-group">
						<div class="input-group">
							<div class="label">Father's Name</div>
							<input class="input-control" id="father-name" name="profile[father]" value="<?php echo $father; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Occupation</div>
							<input class="input-control" id="father-occ" name="profile[father_occupation]" value="<?php echo $father_occupation; ?>" />
						</div>
						<div class="input-group">
							<div class="label">fathers Email</div>
							<input class="input-control" id="profile[father_email]" name="father-email"
								value="<?php echo $father_email;?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Phone No.</div>
							<input class="input-control" id="father-phoneNumber" name="profile[father_phone]"
								value="<?php echo $father_phone; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Alumnus</div>
							<div class="choices">
								<input class="input-control radio" type="radio" id="yes" name="profile[is_alumnus]"
									value="1">
								<label for="yes">Yes</label><br>
								<input class="input-control radio" type="radio" id="no" name="profile[is_alumnus]"
									value="0">
								<label for="no">No</label><br>
							</div>
						</div>
						<div class="input-group">
							<div class="label">Batch</div>
							<input class="input-control" id="father-batch" name="profile[father_batch]" value="<?php echo $father_batch; ?>" />
						</div>
					</div>
				</div>

				<div class="spacer"></div>

				<div class="mother-info">
					<div class="form-group">
						<div class="input-group">
							<div class="label">Mother's Name</div>
							<input class="input-control" id="mother-name" name="profile[mother]" value="<?php echo $mother; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Occupation</div>
							<input class="input-control" id="mother-occ" name="profile[mother_occupation]" value="<?php echo $mother_occupation; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Mothers Email</div>
							<input class="input-control" id="mother-email" name="profile[mother_email]"
								value="<?php echo $mother_email; ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Phone No.</div>
							<input class="input-control" id="mother-phoneNumber" name="profile[mother_phone]"
								value="<?php echo $mother_phone; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Alumna</div>
							<div class="choices">
								<input class="input-control radio" type="radio" id="yes" name="profile[is_alumna]"
									value="1">
								<label for="yes">Yes</label><br>
								<input class="input-control radio" type="radio" id="no" name="profile[is_alumna]"
									value="0">
								<label for="no">No</label><br>
							</div>
						</div>
						<div class="input-group">
							<div class="label">Batch</div>
							<input class="input-control" id="mother-batch" name="profile[mother_batch]" value="<?php echo $mother_batch;?>" />
						</div>
					</div>
				</div>

				<div class="spacer"></div>

				<div class="in-case-emergency">
					<div class="form-group">
						<div class="input-group">
							<div class="title-head">In case of emergency:</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Contact Person</div>
							<input class="input-control" id="contact-person" name="profile[ice_contact_person]"
								value="<?php echo $ice_contact_person; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Phone No.</div>
							<input class="input-control" id="contact-person-phone" name="profile[ice_contact_person_phone]"
								value="<?php echo $ice_contact_person_phone; ?>" />
						</div>
						<div class="input-group">
							<div class="label">Address</div>
							<input class="input-control" id="contact-person-address" name="profile[ice_home_address]" value="<?php echo $ice_home_address; ?>" />
						</div>
					</div>
				</div>

				<div class="spacer-lg"></div>

				<div class="sibling">
					<div class="form-group">
						<div class="input-group">
							<div class="title-head">Siblings Information (Enrolled in SJA)</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<textarea class="input-control" id="siblings" name="profile[siblings_info]"
								rows="8"><?php echo $siblings_info; ?></textarea>
						</div>
					</div>
				</div>

				<div class="spacer"></div>

				<div class="screen action-btn">
					<div class="form-group">
						<div class="input-group">								
						<?php if($srid==RSTUD): ?>
						<?php endif; ?>
						<?php if($srid!=RSTUD) : ?>							
							<br />
							<div class="clear" ><br />
								<div style="margin:6px 0;padding:6px 0;font-size:1.2em;" class="clear" >
									Finalized: <input type="number" style="font-size:1.2em;" 
									min=0 max=1 name="profile[profile_finalized]" value="<?php echo $profile_finalized; ?>" >
								</div>
								<input class="btn input-control datasheet-btn" 
								id="submit" type="submit" name="submit" value="Save" >
							</div>
						<?php endif; ?>

						<?php if(($srid==RSTUD) && ($profile_finalized!=1)): ?>
							<br />
							<div class="" ><br />
							<input class="btn datasheet-btn" 
								 type="submit" name="submit" value="Save"  >							
							<input class="btn datasheet-btn" 
								 type="submit" name="submit" value="Finalize" 
								onclick="return confirm('One time update only. Sure?');" >
							</div>
						<?php endif; ?>
								
								
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
