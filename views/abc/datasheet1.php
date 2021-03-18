<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<style type="text/css" media="screen">
		.dataSheet-wrapper	{
			padding-top: 30PX;
			margin: auto;
		}
		.ds-table table{
			margin: auto;
			width: 850px;
			/*border: 1px solid;
			padding: 30px 20px;
			border-radius: 5px;*/
		}
		/*.ds-table table td,
		.ds-table table th {
			padding: 5px 10px 5px 10px;
			border: 1px solid;
		}*/
		.border {
			border: 1px solid;
			border-radius: 5px;
			padding-left: 5px;
			padding-right: 5px;
			padding-top: 3px;
			padding-bottom: 3px;
		}
		.inline-radio,
		.inline-input,
		.name {
			display: flex;
		}
		.lvl-radio {
			font-weight: bold;
			padding-left: 10px;
		}
		input {
			margin: 3px;
			padding-top: 3px;
			padding-bottom: 3px;
			/*text-align: center;*/
		}
		label {
			padding: 5px;
		}
		.newstud-tbl table,
		.discount-tbl table,
		.siblings-tbl table,
		.assessment-tbl table{
			padding: 10px;
			margin-bottom: 3px;
			border-top: .08em solid;
			/*border-bottom: .08em solid;*/
		}
 	</style>

 	<div class="dataSheet-wrapper">
 		<div class="ds-table">
			<form action="">
				<table>
					<tr>
						<td width="300"  class="border">
							<div class="lvl-radio">
							  	<input type="radio" id="prenursery" name="level" value="prenursery">
							  	<label for="prenusery">___PRE-NURSERY</label><br>
							  	<input type="radio" id="gs" name="level" value="gs">
							  	<label for="gs">___GRADE SCHOOL</label><br>
							  	<input type="radio" id="jhs" name="level" value="jhs">
							  	<label for="jhs">___PRE-NURSERY</label><br>
							  	<input type="radio" id="shs" name="level" value="shs">
							  	<label for="shs">___GRADE SCHOOL</label><br>
							</div>
						</td>
						<th style="font-size: 20px;">ST JAMES ACADEMY</span><br>
							<span style="font-size: 20px;">MALABON CITY</span><br>
							<span style="font-size: 25px;">DATA SHEET</span><br>
						</th>
						<th class="border">
							<p>
								<span><b>STUDENT NO.: <u>2020-00001</u></b></span><br>
								<div class="inline-radio" style="margin-left: 20px;">
								  	<input type="radio" id="new" name="status" value="new">
								  	<label for="new">___NEW</label>
								  	<input type="radio" id="old" name="status" value="old">
								  	<label for="old">___OLD</label>
								</div>
							</p>
						</th>
					</tr>
					<tr>
						<td colspan="2">
							<div class="inline-input lvl">
								<label for="lvl"><b>Kinder/Grade/ Year:</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="lvl" value="Grade 8" name="lvl">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="lvl"><b>Section:</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="section" value="Mark" name="section">
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="inline-input fullname">
								<label for="name"><b>Name:</b></label>&nbsp;&nbsp;
								<input style="width: 100%;" type="text" id="name" value="Rodriguez" name="section"><br>
								<!-- <center><small><b>Family Name</b></small></center> -->
								<input style="width: 100%;" class="stud-name" type="text" id="name" value="John Mark" name="section"><br>
								<!-- <center><small><b>Given Name</b></small></center> -->
								<input style="width: 100%;" class="stud-name" type="text" id="name" value="Cuervas" name="section"><br>
								<!-- <center><small><b>Middle Name</b></small></center> -->
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="inline-radio">
								<label><b>Gender:</b></label>
							  	<input type="radio" id="male" name="gender" value="male">
							  	<label for="male">_MALE</label>
							  	<input type="radio" id="female" name="gender" value="female">
							  	<label for="female">_FEMALE</label>
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="bday"><b>Date of Birth</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="bday" value="09-16-2020" name="bday">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="bplace"><b>Place of Birth</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="bplace" value="Malabon City" name="bplace">
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="inline-input">
								<label for="address"><b>Complete Address</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="address" value="123 Juan St. Gasak Malabon City" name="address">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="telNo"><b>Tel. No.</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="telNo" value="09234567890" name="telNo">
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td>
							<div class="inline-input">
								<label for="religion"><b>Religion</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="religion" value="Catholic" name="religion">
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="inline-input">
								<label for="address"><b>Prov. Address</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="address" value="123 Juan St. Gasak Malabon City" name="address">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="telNo"><b>Tel. No.</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="telNo" value="09234567890" name="telNo">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="inline-input">
								<label for="fr-name"><b>Father's Name</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="fr-name" value="Juan Carlos Rodriguez" name="fr-name">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="fr-occupation"><b>Occupation</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="fr-occupation" value="IT Manager" name="fr-occupation">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="fr-telNo"><b>Tel. No.</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="fr-telNo" value="09951239584" name="fr-telNo">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="inline-radio">
								<label><b>Alumnus:</b></label>
							  	<input type="radio" id="yes" name="alumnus" value="yes">
							  	<label for="yes">YES</label>
							  	<input type="radio" id="no" name="alumnus" value="no">
							  	<label for="no">NO</label>
							</div>
						</td>
						<td>
							<div class="inline-radio">
							  	<input type="radio" id="gs" name="fr-lvl" value="gs">
							  	<label for="gs">Grade School</label>
							  	<input type="radio" id="no" name="fr-lvl" value="hs">
							  	<label for="hs">High School</label>
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="fr-batch"><b>Batch</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="fr-batch" value="2001-2004" name="fr-batch">
							</div>
						</td>
					</tr>

					<tr>
						<td>
							<div class="inline-input">
								<label for="mr-name"><b>Mother's Name</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="mr-name" value="Jasmine Rodriguez" name="mr-name">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="mr-occupation"><b>Occupation</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="mr-occupation" value="House Wife" name="mr-occupation">
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="mr-telNo"><b>Tel. No.</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="mr-telNo" value="09951239584" name="mr-telNo">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="inline-radio">
								<label><b>Alumna:</b></label>
							  	<input type="radio" id="yes" name="alumna" value="yes">
							  	<label for="yes">YES</label>
							  	<input type="radio" id="no" name="alumna" value="no">
							  	<label for="no">NO</label>
							</div>
						</td>
						<td>
							<div class="inline-radio">
							  	<input type="radio" id="gs" name="mr-lvl" value="gs">
							  	<label for="gs">Grade School</label>
							  	<input type="radio" id="no" name="mr-lvl" value="hs">
							  	<label for="hs">High School</label>
							</div>
						</td>
						<td>
							<div class="inline-input">
								<label for="mr-batch"><b>Batch</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="mr-batch" value="2004-2008" name="mr-batch">
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="inline-input">
								<label for="email"><b>Batch</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="email" id="email" value="Sample123@gmail.com" name="email">
							</div>
						</td>
						<td>&nbsp;</td>
					</tr>
		 		</table>
		 		<br>
		 		<div class="newstud-tbl">
			 		<table class="newstud-tbl">
			 			<tr>
			 				<th colspan="3" style="border:1px solid; padding: 5px;">
			 					<span>FOR NEW STUDENT only</span>
			 				</th>
			 			</tr>
			 			<tr>
							<td>
								<div class="inline-input">
									<label for="lsa"><b>Last School Attended</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="lsa" value="UP Diliman" name="lsa">
								</div>
							</td>
							<td>
								<div class="inline-input">
									<label for="lsa-sy"><b>School Year</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="lsa-sy" value="2014-2018" name="lsa-sy">
								</div>
							</td>
							<td>
								<div class="inline-input">
									<label for="lsa-lvl"><b>Grade/Year</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="lsa-lvl" value="Grade 8" name="lsa-lvl">
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<div class="inline-input">
									<label for="lsa-address"><b>School Address</b></label>&nbsp;&nbsp;<input style="width: 100%;" type="text" id="lsa-address" value="UP Dilaman Quezon City" name="lsa-address">
								</div>
							</td>
						</tr>
			 		</table>
		 		</div>
		 		<div class="discount-tbl">
			 		<table>
		 				<tr>
		 					<td>
		 						<div class="inline-input">
		 							<input type="radio" id="acad" name="discount" value="acad">
									<label for="acad"><b>Academic Scholar</b></label>
								</div>
		 					</td>
		 					<td>
		 						<div class="inline-input">
		 							<input type="radio" id="esc" name="discount" value="esc">
									<label for="esc"><b>ESC / Voucher Grantee</b></label>
								</div>
		 					</td>
		 					<td>
		 						<div class="inline-input">
		 							<input type="radio" id="pta" name="discount" value="pta">
									<label for="pta"><b>PTA / Alumni Scholar</b></label>
								</div>
		 					</td>
		 					<td>
		 						<div class="inline-input">
		 							<input type="radio" id="fbenefits" name="discount" value="fbenefits">
									<label for="fbenefits"><b>F/Benefits</b></label>
								</div>
		 					</td>
		 				</tr>
		 			</table>
		 		</div>
		 		<div class="siblings-tbl">
		 			<table>
		 				<tr>
		 					<td colspan="2">
		 						<span style="font-size: 25px;"><b>Brothers / Sisters enrolled in this School:</b></span>
		 					</td>
		 				</tr>
		 				<tr>
		 					<th>Name</th>
			 				<th>Grade / Year</th>
		 				</tr>
		 				<tr>
		 					<td>
		 						<div class="inline-input">
		 							<input style="width: 100%;" type="text" id="child-name" value="JUAN RODRIQUEZ" name="child-name">
		 						</div>
		 					</td>
		 					<td>
		 						<div class="inline-input">
		 							<input style="width: 100%;" type="text" id="level" value="Grade 4" name="level">
		 						</div>
		 					</td>
		 				</tr>
		 				<tr>
		 					<td>
		 						<div class="inline-input">
		 							<input style="width: 100%;" type="text" id="child-name" value="SARAH RODRIQUEZ" name="child-name">
		 						</div>
		 					</td>
		 					<td>
		 						<div class="inline-input">
		 							<input style="width: 100%;" type="text" id="level" value="Grade 9" name="level">
		 						</div>
		 					</td>
		 				</tr>
		 				<tr>
		 					<td>
		 						<div class="inline-input">
		 							<input style="width: 100%;" type="text" id="child-name" value="SET RODRIQUEZ" name="child-name">
		 						</div>
		 					</td>
		 					<td>
		 						<div class="inline-input">
		 							<input style="width: 100%;" type="text" id="level" value="Grade 12" name="level">
		 						</div>
		 					</td>
		 				</tr>
		 			</table>
		 		</div>
		 		<div class="assessment-tbl">
		 			<table>	
		 				<tr>
		 					<td colspan="4">
		 						<label><b>ASSESSMENT:</b></label>
		 					</td>
		 				</tr>
		 				<tr>
	 						<td>
	 							<div class="inline-radio">
								  	<input type="radio" id="fullPay" name="paymode" value="fullPay">
								  	<label for="fullPay"><b>FULL PAYMENT</b></label>
								</div>
	 						</td>
	 						<td>
	 							<div class="inline-radio">
								  	<input type="radio" id="sem" name="paymode" value="sem">
								  	<label for="sem"><b>SEMESTRAL</b></label>
								</div>
	 						</td>
	 						<td>
	 							<div class="inline-radio">
								  	<input type="radio" id="qtr" name="paymode" value="qtr">
								  	<label for="qtr"><b>QUARTERLY</b></label>
								</div>
	 						</td>
	 						<td>
	 							<div class="inline-radio">
								  	<input type="radio" id="month" name="paymode" value="month">
								  	<label for="month"><b>MONTHLY</b></label>
								</div>
	 						</td>
		 				</tr>
			 		</table>
		 		</div>
			</form>
 		</div>
 	</div>
</body>
</html>
