<?php
	function numberToWords($num) {
		switch($num){
			case 3: return '3 (Three)'; break;
			case 4: return '4 (Four)'; break;
			case 5: return '5 (Five)'; break;	
			case 6: return '6 (Six)'; break;
			case 7: return '7 (Seven)'; break;
			case 8: return '8 (Eight)'; break;
			default: return 'NA'; break;
		}
	}
	// $x = numberToWords(5); 
	// pr($x);
	// exit;

?>

<style>
	table, tr, td, th {
		border-collapse: collapse;
		vertical-align: top;
		padding: 0em .3em;
	}
	.table-bordered {
		border: 1px solid #ddd;
	}   
	.table-bordered th,
	.table-bordered td {
		margin: 0;
		border: 1px solid #ddd;
		padding: 3px 10px;
	}
	.grade-tbl th {
		text-align: center;
	}
	.left_txt {
		text-align: left;
	}
	.transcript {
		margin: auto;
		width: 1000px;
	}
	.header {
		display: flex;
	}
	.school_logo {
		padding-left: 20px;
		padding-top: 30px;
		padding-bottom: 30px;
	}
	.school_name{
		text-align: center;
		margin: auto;
	}
	.school_address {
		font-size: 17px;
	}
	.head_desc {
		text-transform: uppercase;
		font-size: 18px;
	}
	.sent_to {
		text-align: center;
		padding: 15px;
	}
	.student_info table,
	.transcript_grade table,
	.attd table {
		margin: auto;
		width: 950px;
	}
	.student_info table th {
		text-align: left;
	}
	.student_info table th,
	.student_info table td {
		padding: 2px;
	}
	.student_info table {
		padding: 5px;
	}
	.tbl-data {
		border-bottom: 1px solid;
		text-align: center;
		/* text-transform: uppercase; */
	}
	.grade-header table {
		margin-top: 5px;
		border-top: 2px solid;
	}
	.attd table {
		margin-top: 2px;
		text-align: center;
	}
</style>
<?php 
	$decicard=$_SESSION['settings']['decicard'];
	$attd_qtr=$_SESSION['settings']['attd_qtr'];
	$attd_qtr=false;
	$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";

?>
<h3 class="" >
	Transcript | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'profiles/scid/'.$scid; ?>" >Profile</a>	
</h3>
<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>
<?php 
	// pr($scid);
	// pr($classrooms);
	// exit;

?>
<?php if($scid): ?>
	<!-- <table class="table-bordered table-altrow" >
		<tr><td><?php echo $student['code']; ?></td>
			<td><?php echo $student['name']; ?></td></tr>
	</table><br /> -->
	<?php 
		$one=SITE."views/customs/".VCFOLDER."/profiles/profileTranscript.php";$two="incs/profileTranscript.php";
		// $incs=(is_readable($one))? $one:$two;include_once($incs); 
		// include_once("incs/studentInfo.php");
	?>
    <div class="transcript">
        <div class="header">
            <div class="school_logo">
                <img src="<?php echo $logo_src; ?>" alt="logo" height="100" width="100">
            </div>
            <div class="school_name">
                <h2>
                    ST. ANTHONY SCHOOL <br>
                    <span class="school_address">Singalong, Manila</span><br>
                    <span class="head_desc">paascu accredited level II <br> learner's permanent academic record for junior high school</span>
                </h2>
            </div>
            <div class="sent_to">
                <table class="table-bordered">
                    <tr>
                        <td>Copy of this record<br>send to:</td>
                    </tr>
                    <tr>
                        <td height="20px"></td>
                    </tr>
                    <tr>
                        <td height="20px"></td>
                    </tr>
                    <tr>
                        <td height="20px"></td>
                    </tr>
                </table>
            </div>
        </div>
        <hr>
        <div class="student_info">
            <table>
                <tr>
                    <th>Name: </th>
                    <td class="tbl-data" colspan="3"><?php echo $student['last_name']?>, <?php echo $student['first_name']?> <?php echo $student['middle_name']?></td>
                    <th width="80">Student #: </th>
                    <td class="tbl-data"><?php echo $student['code']; ?></td>
                    <th width="65">LRN: </th>
                    <td class="tbl-data" >lrn data</td>
                </tr>
                <tr>
                    <th>Date of Birth: </th>
                    <td class="tbl-data"><?php echo $student['birthdate']?></td>
                    <th>Place of Birth:</th>
                    <td class="tbl-data"><?php echo $student['birthplace']?></td>
                    <th>Gender: </th>
                    <td class="tbl-data">gender data</td>
                    <th>Religion:</th>
                    <td class="tbl-data"><?php echo $student['religion']?></td>
                </tr>
                <tr>
                    <th rowspan="2" colspan="2">Parent / Guardian: </th>
                    <th >Father: </th>
                    <td class="tbl-data"><?php echo $student['father']?></td>
                    <th >Occupation:</th>
                    <td class="tbl-data" colspan="3"><?php echo $student['father_occupation']?></td>
                </tr>
                <tr>
                    <th >Mother: </th>
                    <td class="tbl-data"><?php echo $student['mother']?></td>
                    <th >Occupation:</th>
                    <td class="tbl-data" colspan="3"><?php echo $student['mother_occupation']?></td>
                </tr>
                <tr>
                    <th colspan="2">Address of Parent / Guardian: </th>
                    <td class="tbl-data" width="300" colspan="2"><?php echo $student['address']?></td>
                    <th>Brgy: </th>
                    <td class="tbl-data" colspan="3"><?php echo $student['barangay']?></td>
                </tr>
                <tr>
                    <th colspan="3">Intermediate Course Completed: </th>
                    <td class="tbl-data"><?php echo 'Grade ' . $student['grade_int_gs'] ?></td>
                    <th>Year: </th>
                    <td class="tbl-data"><?php echo $student['year_int_gs'] ?></td>
                    <th>Average: </th>
                    <td class="tbl-data"><?php echo $student['genave_gs'] ?></td>
                </tr>
                <tr>
                    <th colspan="4">Total no.  of years in school to complete Elementary Course:  <span class="tbl-data">
					<?php $ny=numberToWords($student['numyears_gs']); echo $ny;  ?></span></th>
                    <!-- <td class="tbl-data" colspan="">Six (6)</td> -->
                </tr>
            </table>
        </div>
        <hr>
        <div class="transcript_grade">
            <div class="grade-header">
                <table class="table-bordered">
                    <tr>
                        <th colspan="9" class="tbl-data">SCHOLASTIC RECORD</th>
                    </tr>
                </table>
            </div>
            <div class="grade">
				<?php for($y=0;$y<$iyears;$y++): ?>
				<table class="table-bordered grade-tbl">	
					<?php $count=$counts[$y]; ?>
					<tr>
                        <th>Classified as: <span class="tbl-data">Lvl #<?php echo $classrooms[$y]['level_id']; ?></span></th>
                        <th colspan="6">School: <span class="tbl-data">St. Anthony Manila</span></th>
                        <th colspan="3">SY: <span class="tbl-data">2014 - 2015</span></th>
                    </tr>
                    <tr>
                        <th rowspan="2">LEARNING AREAS</th>
                        <th colspan="4">GRADING PERIOD</th>
                        <th rowspan="2" width="30">Final Grade</th>
                        <th rowspan="2" width="30">Action Taken</th>
                        <th colspan="2" class="left_txt">SUMMER:</th>
                    </tr>
                    <tr>
                        <th width="25">1</th>
                        <th width="25">2</th>
                        <th width="25">3</th>
                        <th width="25">4</th>
                        <th>Subject/s</th>
                        <th>Final Grade</th>
                    </tr>
					<?php for($i=0;$i<$count;$i++): ?>
					<?php $is_num=($grades[$y][$i]['is_num']==1)? 1:0; ?>
						<?php if($is_num): ?>
							<tr>
								<td><?php echo $grades[$y][$i]['label']; ?></td>
								<td class="tbl-data"><?php $q1=number_format($grades[$y][$i]['q1'],$decicard);echo $q1; ?></td>
								<td class="tbl-data"><?php $q2=number_format($grades[$y][$i]['q2'],$decicard);echo $q2; ?></td>
								<td class="tbl-data"><?php $q3=number_format($grades[$y][$i]['q3'],$decicard);echo $q3; ?></td>
								<td class="tbl-data"><?php $q4=number_format($grades[$y][$i]['q4'],$decicard);echo $q4; ?></td>
								<td class="tbl-data"><?php $q5=number_format($grades[$y][$i]['q5'],$decicard);echo $q5; ?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php else: ?>	
							<tr>
								<td><?php echo $grades[$y][$i]['label']; ?></td>
								<td class="tbl-data"><?php $dg1=$grades[$y][$i]['dg1'];echo $dg1; ?></td>
								<td class="tbl-data"><?php $dg2=$grades[$y][$i]['dg2'];echo $dg2; ?></td>
								<td class="tbl-data"><?php $dg3=$grades[$y][$i]['dg3'];echo $dg3; ?></td>
								<td class="tbl-data"><?php $dg4=$grades[$y][$i]['dg4'];echo $dg4; ?></td>
								<td class="tbl-data"><?php $dg5=$grades[$y][$i]['dg5'];echo $dg5; ?></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php endif; ?>
					<?php endfor; ?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<th>GENERAL AVERAGE</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<td></td>
							<td></td>
						</tr>			
				</table>
				<div class="attd">
					<table class="table-bordered">
					<?php $months=&$attdmonths[$y];$attendance=&$attendances[$y]; ?>
					<?php if($attd_qtr): ?>
						<tr>
							<th></th>
							<th class="tbl-data">1</th>
							<th class="tbl-data">2</th>
							<th class="tbl-data">3</th>
							<th class="tbl-data">4</th>
							<th class="tbl-data" width="15">Total</th>
							<td class="tbl-data" style="text-transform:uppercase;"><?php echo $classrooms[$y]['adviser']; ?></td>
						</tr>
						<tr><td style="text-align:left;" class="b subwidth" >Number of School Days</td>
							<td class="tbl-data"><?php echo $months['q1_days_total']+0; ?></td>
							<td class="tbl-data"><?php echo $months['q2_days_total']+0; ?></td>
							<td class="tbl-data"><?php echo $months['q3_days_total']+0; ?></td>
							<td class="tbl-data"><?php echo $months['q4_days_total']+0; ?></td>
							<td class="tbl-data"><?php echo $months['year_days_total']+0; ?></td>
							<th class="tbl-data"><small>Adviser</small></th>
						</tr>
						<tr><th style="text-align:left;" >Days Present</th>
							<td class="tbl-data"><?php echo $attendance['q1_days_present']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['q2_days_present']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['q3_days_present']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['q4_days_present']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['total_days_present']+0; ?></td>
							<td class="tbl-data"><?php echo $classrooms[$y]['name']; ?></td>
						</tr>
						<tr><th style="text-align:left;" >Times Tardy</th>
							<td class="tbl-data"><?php echo $attendance['q1_days_tardy']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['q2_days_tardy']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['q3_days_tardy']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['q4_days_tardy']+0; ?></td>
							<td class="tbl-data"><?php echo $attendance['total_days_tardy']+0; ?></td>
							<th class="tbl-data"><small>Section</small></th>
						</tr>
						<tr>
							<th class="tbl-data" colspan="14">Total no. of years in school to date: <?php echo $classrooms[$y]['level_id']; ?></th>
						</tr>
					<?php else :?>
						<tr>
							<th>Month</th>
							<?php for($k=0;$k<$num_months;$k++): ?>
								<?php $month_code = $month_names[$k]['code'];  ?>
								<th class="" ><?php echo ucfirst($month_code); ?></th>
							<?php endfor; ?>
							<th width="15">Total</th>
							<td class="tbl-data" style="text-transform:uppercase;"><?php echo $classrooms[$y]['adviser']; ?></td>
						</tr>
						<tr>
							<th class="left_txt" width="120">Days of School</th>
							<?php for($k=0;$k<$num_months;$k++): ?>		
								<?php $month_code=$month_names[$k]['code']; ?>		
								<td class="tbl-data"><?php echo round($months[$month_code.'_days_total']); ?></td>
							<?php endfor; ?>
							<td class="tbl-data"><?php echo ($months['year_days_total']+0); ?></td>	
							<th class="tbl-data"><small>Adviser</small></th>
						</tr>
						<tr>
							<th class="left_txt">Days Present</th>
							<?php for($k=0;$k<$num_months;$k++): ?>
								<?php $month_code=$month_names[$k]['code']; ?>
								<?php $attdpre=$attendance[$month_code.'_days_present']+0; ?>
								<td class="tbl-data"><?php echo $attdpre; ?></td>
							<?php endfor; ?>	
							<td class="tbl-data"><?php echo ($attendance['total_days_present']+0); ?></td>
							<td class="tbl-data"><?php echo $classrooms[$y]['name']; ?></td>
						</tr>
						<tr>
							<th class="left_txt">Days Tardy</th>
							<?php for($k=0;$k<$num_months;$k++): ?>
								<?php $month_code=$month_names[$k]['code']; ?>
								<?php $attdtar=$attendance[$month_code.'_days_tardy']+0; ?>		
								<td class="tbl-data"><?php echo $attdtar; ?></td>
							<?php endfor; ?>	
							<td class="tbl-data"><?php echo ($attendance['total_days_tardy']+0); ?></td>	
							<th class="tbl-data"><small>Section</small></th>
						</tr>
						<tr>
							<th class="tbl-data" colspan="14">Total no. of years in school to date: <?php echo $classrooms[$y]['level_id']; ?></th>
						</tr>
					<?php endif ?>
					</table>


					<!-- <?php 
						$months=&$attdmonths[$y];$attendance=&$attendances[$y];	
						if($attd_qtr){ $incs="attd_qtr.php";include($incs); } else {
							$incs="attd_mos.php";include($incs); }
						
					?>		 -->
				</div>
				<?php endfor; ?>
            </div>
        </div>
    </div>
	<br>
<?php endif; ?>

<script>
var gurl="http://<?php echo GURL; ?>";
var limits='30';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url=gurl+'/transcripts/scid/'+ucid;	
	window.location=url;		
}


</script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
