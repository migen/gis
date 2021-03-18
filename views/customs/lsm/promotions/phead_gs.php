<?php 

$ssg = $_SESSION['settings'];
$spacing = 12;

?>



<?php 



?>




<!---------------------------------------------------------------------------------------------------->


<div class="center" >	<!-- phead -->
<div class="unbordered" style="width:80px;float:left;padding-top:24px;"  >
	<?php $logo_src = URL."public/images/deped_logo.png"; ?>
	<img src='<?php echo $logo_src; ?>' alt="logo" height="76" width="76" >
</div>	<!-- deped logo -->

<div style="width:820px;float:left;" class="unbordered" >
<p>
<span class="b" style="font-size:1.2em;"  >School Form 5 (SF5) Report on Promotion and Learning Progress & Achievement</span><br />
<span style="font-size:1.0em;" >Revised to conform with the instructions of DepEd Order 8, s. 2015</span>
</p>

<table class="nogis-table-bordered" style="font-size:0.7em;" >
<tr>
<td class="right" >Region</td><td><input class="vc80 pdl05" value="NCR" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Division</td>
<td><input style="width:160px;" class="pdl05" value="<?php echo $ssg['school_division']; ?>" /></td>
<td class="vc80" >District</td>
<td><input style="width:120px;" class="pdl05" value="Mandaluyong" /></td>
<td>&nbsp;</td>
</tr>

<tr>
<td class="right" >School ID</td>
<td><input class="vc150 pdl05" value="406760" /></td>
<td>School Year &nbsp;<input class="pdl05" style="width:90px;" value="<?php echo DBYR.' - '.(DBYR+1); ?>" /></td>
<td>Curriculum</td>
<td><input style="width:50px;" class="pdl05" value="<?php echo 'K12'; ?>" /></td>
<td></td>
</tr>

<tr>
<td class="right" >School Name</td>
<td colspan="2" style="padding-right:20px;" ><input class="full pdl05" value="<?php echo $ssg['school_name']; ?>" /></td>
<td>Grade Level</td>
<td><input style="width:60px;" class="pdl05" value="<?php echo $classroom['level']; ?>" />&nbsp;&nbsp;&nbsp;Section</td>
<td><textarea cols="24" rows="1" ><?php echo $classroom['section']; ?></textarea></td>
</tr>
</table>


</div>


</div>	<!-- phead -->	







<div class="clear" >&nbsp;</div>
