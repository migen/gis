<?php

require_once('datasheet_sjam_model.php');
$today=$_SESSION['today'];

/* locking */
$is_locked=($srid==RSTUD)? isFinalizedEnstep($db,$scid,$enstep=1):false;
// echo "<br>";echo ($is_locked)? "locked":"open";echo "<br>";


?>

<div class='screen'>

<h3 class="pagelinks" >
	SJAM Datasheet 
	| <?php $this->shovel('homelinks'); ?>
	<?php if($scid): ?>
		| <a href="<?php echo URL.'students/ds/'.$scid.DS.$sy; ?>" >DS</a>
	<?php endif; ?>
	| <?php echo ($is_locked==1)? 'Locked':'Open'; ?>
</h3>

<?php 

/* navigation controls */
echo $controls."<div class='clear'>&nbsp;</div>";


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
			<form class="datasheet-form" action="" method="POST" id="form" >			
				<div class="status">
					<div class="status-choices">
						<label class="form-check-label">
							<input type="radio" class="input-control" name="profile[is_old_student]" 
								value="1" <?php echo ($is_old_student==1)? 'checked':null; ?> />Old
						</label>
						<label class="form-check-label">
							<input type="radio" class="input-control" name="profile[is_old_student]" 
								value="0" <?php echo ($is_old_student==0)? 'checked':null; ?> />New
						</label>
						<div class="input-group">
							<div class="label">Last School Attended</div>
							<input class="input-control" id="lsa" name="profile[lsa]" value="<?php echo $lsa; ?>" />
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
							<input class="input-control" id="address" name="profile[address]" value="<?php echo $address; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Gender</div>
							<div class="choices">								
								<input class="input-control radio" type="radio" id="male" name="contact[is_male]"  
									value="1" <?php echo ($contact['is_male']==1)? 'checked':null; ?> >
								<label for="female">Male</label><br>
								<input class="input-control radio" type="radio" id="female" name="contact[is_male]" 
									value="0" <?php echo ($contact['is_male']==0)? 'checked':null; ?> >
								<label for="female">Female</label><br>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Birthday</div>
							<input class="input-control" id="birthday" name="profile[birthdate]" value="<?php echo $birthdate; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Birth Place</div>
							<input class="input-control" id="birthplace" name="profile[birthplace]" value="<?php echo $birthplace; ?>" required/>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Age</div>
							<input class="input-control" id="age" name="profile[age]" value="<?php echo $age . ' Years Old';?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Religion</div>
							<input class="input-control" id="religion" name="profile[religion]" value="<?php echo $religion; ?>" required/>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Nationality</div>
							<input class="input-control" id="nationality" name="profile[nationality]" value="<?php echo $nationality; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Tel. No.</div>
							<input class="input-control" id="telNumber" name="profile[phone]" value="<?php echo $phone?>" required/>
						</div>
					</div>
				</div>

				<div class="spacer-lg"></div>

				<div class="scholarship">
					<div class="form-group">
						<div class="input-group">
							<div class="label">Employee's Child</div>
							<input class="input-control radio" type="radio" name="profile[is_employee_child]" 
								value="1" <?php echo ($is_employee_child==1)? 'checked':null; ?> >
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" name="profile[is_employee_child]" 
								value="0" <?php echo ($is_employee_child==0)? 'checked':null; ?> >
							<label for="female">No</label><br>
						</div>
						<div class="input-group">
							<div class="label">Esc Grantee</div>
							<input class="input-control radio" type="radio" id="yes" name="profile[is_esc_grantee]" 
								value="1" <?php echo ($is_esc_grantee==1)? 'checked':null; ?> >
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" id="no" name="profile[is_esc_grantee]" 
								value="0" <?php echo ($is_esc_grantee==0)? 'checked':null; ?> >
							<label for="female">No</label><br>
						</div>
						<div class="input-group">
							<div class="label">Academic Scholar</div>
							<input class="input-control radio" type="radio" name="profile[is_scholar_academic]" 
								value="1" <?php echo ($is_scholar_academic==1)? 'checked':null; ?> >
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" name="profile[is_scholar_academic]" 
								value="0" <?php echo ($is_scholar_academic==0)? 'checked':null; ?> >
							<label for="female">No</label><br>
						</div>
						<div class="input-group">
							<div class="label">PTA Scholar</div>
							<input class="input-control radio" type="radio" id="yes" name="profile[is_scholar_pta]" 
								value="1" <?php echo ($is_scholar_pta==1)? 'checked':null; ?> >
							<label for="female">Yes</label><br>
							<input class="input-control radio" type="radio" id="no" name="profile[is_scholar_pta]" 
								value="0" <?php echo ($is_scholar_pta==0)? 'checked':null; ?> >
							<label for="female">No</label><br>
						</div>
					</div>
				</div>

				<div class="spacer-lg"></div>

				<div class="father-info">
					<div class="form-group">
						<div class="input-group">
							<div class="label">Father's Name</div>
							<input class="input-control" id="father-name" name="profile[father]" value="<?php echo $father; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Occupation</div>
							<input class="input-control" id="father-occ" name="profile[father_occupation]" value="<?php echo $father_occupation; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Email Address</div>
							<input class="input-control" name="profile[father_email]"
								value="<?php echo $father_email;?>" required/>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Phone No.</div>
							<input class="input-control" name="profile[father_phone]"
								value="<?php echo $father_phone; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Alumnus</div>
							<div class="choices">
								<input class="input-control radio" type="radio" id="yes" name="profile[is_alumnus]"
									value="1" <?php echo ($is_alumnus==1)? 'checked':null; ?>  >
								<label for="yes">Yes</label><br>
								<input class="input-control radio" type="radio" id="no" name="profile[is_alumnus]"
									value="0" <?php echo ($is_alumnus==0)? 'checked':null; ?> >
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
							<input class="input-control" id="mother-name" name="profile[mother]" value="<?php echo $mother; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Occupation</div>
							<input class="input-control" id="mother-occ" name="profile[mother_occupation]" value="<?php echo $mother_occupation; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Email Address</div>
							<input class="input-control" id="mother-email" name="profile[mother_email]"
								value="<?php echo $mother_email; ?>" required/>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="label">Phone No.</div>
							<input class="input-control" id="mother-phoneNumber" name="profile[mother_phone]"
								value="<?php echo $mother_phone; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Alumna</div>
							<div class="choices">
								<input class="input-control radio" type="radio" id="yes" name="profile[is_alumna]"
									value="1" <?php echo ($is_alumna==1)? 'checked':null; ?> >
								<label for="yes">Yes</label><br>
								<input class="input-control radio" type="radio" id="no" name="profile[is_alumna]"
									value="0" <?php echo ($is_alumna==0)? 'checked':null; ?> >
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
								value="<?php echo $ice_contact_person; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Phone No.</div>
							<input class="input-control" id="contact-person-phone" name="profile[ice_contact_person_phone]"
								value="<?php echo $ice_contact_person_phone; ?>" required/>
						</div>
						<div class="input-group">
							<div class="label">Address</div>
							<input class="input-control" id="contact-person-address" name="profile[ice_home_address]" value="<?php echo $ice_home_address; ?>" required/>
						</div>
					</div>
				</div>

				<div class="spacer-lg"></div>

				<div class="sibling">
					<div class="form-group">
						<div class="input-group">
							<div class="title-head">SIBLING/S INFORMATION (NAME AND GRADE LEVEL OF SIBLING/S ENROLLED IN SJA)</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<textarea class="input-control" id="siblings" name="profile[siblings_info]"
								rows="8" required><?php echo $siblings_info; ?></textarea>
						</div>
					</div>
				</div>

				<div class="spacer"></div>


				<div class="screen clear action-btn">
					<div class="form-group">
						<div class="input-group">								
						<?php if($srid!=RSTUD) : ?>							
							<input class="btn input-control datasheet-btn" 
							id="submit" type="submit" name="submit" value="Save" >
						<?php endif; ?>

						<?php if(($srid==RSTUD) && (!$is_locked)): ?>
							<br />
							<div class="" ><br />
							<input class="btn datasheet-btn" 
								 type="submit" name="submit" value="Save"  >							
							<input class="btn datasheet-btn" id="btnFinalize"
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




<script>

	var today="<?php echo $today; ?>";
	

	$(function(){
		selectFocused();
		nextViaEnter();
		$('#names').hide();
		$('html').live('click',function(){ $('#names').hide(); });

		$('#btnFinalize').click(function(){
			var lock = "<input name='contact[enstep]' readonly value=2 >";
			lock+="<input name='step[finalized_s1]' readonly value='"+today+"' >";
			$('#form').append(lock);
		})

/* 		
		$('#btnFinalize').click(function(){
			var lock = "<input name='profile[profile_finalized]' value=1 >";
			$('#form').append(lock);
		})
 */		
		
	})


</script>
