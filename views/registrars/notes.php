<h5>	
	<?php $sy = $_SESSION['sy']; ?>
	Registrars Notes <?php echo $sy; ?>
	<?php $controller = ($_SESSION['user']['role_id']==5)? 'mis':'registrars';  ?>
	<a href="<?php echo URL.$controller; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

	<?php if($_SESSION['user']['role_id']==5): ?>
		| <a href="<?php echo URL.'setup/grading'; ?>" > Setup </a>
		| <a href="<?php echo URL.'mis/dashboard'; ?>" > Dashboard </a>	
	<?php endif; ?>
</h5>

<!---------------------------------------------------------------------------------------------------------------->

<?php 
	
	// for resetting students.is_enrolled upon jan 1 of new year
	$this_year = date('Y');
	
?>

<!---------------------------------------------------------------------------------------------------------------->


<table class="gis-table-bordered table-fx table-altrow"  >

<tr class="headrow" ><th>&nbsp;</th><th class="vc500 white" > Particular </th><th class="vc100 white" > Role </th></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Promote to next level TMP section for next SY  </td><td> Adviser </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Registrar - Set New SY after all classrooms promoted to TMP. 
<br />a) SY-Qtr b) Open Settings sectioning,c) Open classrooms for Init Grades,d) Update Tuition Summaries,e) Update Old SY Summaries (crid,acid)
f) Init New SY Students-Summaries (enrollment)
</td><td> Registrar </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > MIS Dashboard Sync Promotions if necessary. </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <b>Caution: </b>Re-sectioning only AFTER settings SY has been updated. </td><td> Registrar </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Update components both acad and non-acad courses if necessary </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Assign <b>Teacher</b> to classroom subject including aggregates  </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Assign <b>Department</b> to employees ESP. to coordinators. </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Set total days for months attendance and Update months-qtrs. </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Update classroom advisers if necessary  </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Update courses if necessary </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <b>Caution</b>: Use averages/course Sync Grades with Care - CANNOT use at the end of SY when students have been promoted or re-sectioned or else will DELETE ALL GRADES.  </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <b>Caution</b>: Editing of Grades - will NOT affect official ranking to avoid potential violent problems in the community.  </td><td> Registrar </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <b>qtrly update settings Value for qtr.  </td><td> Registrar </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Enrollment 1) Promotions to TMP - CSY,2) TMP Batch Sectioning / Single Enrollment - NSY </td><td> 1) Adviser,2) Registrar </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Sectioning must be locked at all times except during enrollment. </td><td> Registrar </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > 1) Ubuntu svr,2) a - cat htaccess folders,b - 000-default.conf,3) a - install phpmyadmin,b - user (local,%,::1) 4) php.ini vars  </td><td> MIS </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > 
<b>setNewSY Condtions</b> (a) Qtr == 4  (b) ClassroomPromotions all finalized (c) Settings isFinalized Sectioning  </td><td> Registrars </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > 
<b>setNewSY Processes</b> - (a) Settings - set new SY,Qtr,isFinalizedSectioning=>0 (b) set AdvQtr & CrsQtr => 0 (c) if applicable (update Classroom Courses - MIS)
(d) all classrooms Set isInitGrades => 0 and initGradesSY => $newSY (e) initTuition (f) syncSS (initSummaries)
</td><td> Registrars </td></tr>

</table>

<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';var x;

$(function(){
	rc('rc');

	
})


function rc(cls){
	var x;
	$('.'+cls).each(function(){
		x = this.rowIndex;
		$(this).find("td:first").text(x);
	});
}
	
	
</script>