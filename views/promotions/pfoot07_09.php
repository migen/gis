<!-- 

<input style="border:none;" class="vc150 center u" 
value="<?php echo 'xxxx_____'.$_SESSION['settings']['school_principal'].'_____'; ?>" />

-->


<?php 

$spacing = 12;
$fontfoot = "tf14";
$fontfooter = "tf14";
$bordercolor = "white";

// pr($prep);

?>


<style>
#footleft{
	width:40%;
	float:left;
	padding-top:30px;
	text-align:left;
	padding-left:10px; 
	border:1px solid <?php echo $bordercolor; ?>;
	margin:0;

}

#footcenter{
	width:26%;
	float:left;
	margin:0;
	padding: 0 12px;
	border:1px solid <?php echo $bordercolor; ?>;	
}



#footright{
	width:25%;
	float:left;
	margin:0;
	padding: 0 12px;	
	border:1px solid <?php echo $bordercolor; ?>;
	
}


.foothalf{

	width:45%;
	float:left;
	border:1px solid <?php echo $bordercolor; ?>;

}



</style>

<?php 



?>

<p class='pagebreak'>&nbsp; </p>
<div class="clear ht50" >&nbsp;</div>

<div id="footleft" class="<?php echo $fontfooter; ?>" >

<p style="text-align: center;">DeP Ed Form 18-E-2 </p>
<hr />
<p style="text-align: center;"><br />REPUBLIC OF THE PHILIPPINES <br />DEPARTMENT OF EDUCATION </p>
<hr />
<p style="text-align: center;"><br />
<strong>REPORT ON PROMOTION</strong>&nbsp;<br />
(GRADE IV-VI)&nbsp;</p>
<p>
Curriculum Basic Education Curiculum&nbsp;
<?php echo $classroom['level']; ?> <br />
Section <?php echo $classroom['section']; ?> <br />
School <?php echo $_SESSION['settings']['school_name']; ?> <br />
Division <?php echo $_SESSION['settings']['school_city']; ?> <br />
Date of Close of school Year <?php echo date('F d, Y',strtotime($_SESSION['settings']['school_closed'])); ?> <br />
Certificate <br />

<input style="border:none;" class="vc150 center u" 
value="<?php echo '__'.date('F d, Y',strtotime($_SESSION['today'])).'_____'; ?>" />

(Date Issued)
</p>
<table border="0" class="gis-table-bordered" >
<tbody>
<tr><td>Summary</td><td>BOYS</td><td>GIRLS</td><td>TOTAL</td></tr>
<tr>
	<td>March monthly enrolment</td>
	<td><?php echo $prep['count_boys']; ?></td>
	<td><?php echo $prep['count_girls']; ?></td>
	<td><?php echo $prep['count_total']; ?></td>
</tr>

<tr>
	<td>Pupils promoted from grade during&nbsp;</td>
	<td><?php echo $prep['count_promoted_boys']; ?></td>
	<td><?php echo $prep['count_promoted_girls']; ?></td>
	<td><?php echo $prep['count_promoted_total']; ?></td>
</tr>

<tr>
	<td>Corrected enrolment</td>
	<td><input class="vc30" style="border:none;" value="<?php echo $prep['count_boys']; ?>" /></td>
	<td><input class="vc30" style="border:none;" value="<?php echo $prep['count_girls']; ?>" /></td>
	<td><input class="vc30" style="border:none;" value="<?php echo $prep['count_total']; ?>" /></td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

<tr>
	<td>Total age of pupils</td>
	<td><?php echo $prep['sum_age_boys']; ?></td>
	<td><?php echo $prep['sum_age_girls']; ?></td>
	<td><?php echo $prep['sum_age_total']; ?></td>
</tr>

<tr>
<td>Average age of pupils</td>
	<td><?php echo $prep['ave_age_boys']; ?></td>
	<td><?php echo $prep['ave_age_girls']; ?></td>
	<td><?php echo $prep['ave_age_total']; ?></td>
</tr>
</tbody>
</table>

<br />

<!------------------------------------------------------------------------------------------------------------------------>

<table class="gis-table-bordered" >

<tr>
	<td>Summary of <br />Promoted Pupils</td>
	<td colspan="2" >During<br />Year</td>
	<td colspan="2" >In<br />April</td>
	<td colspan="3" >Total</td>
</tr>

<tr>
	<td>Number Promoted</td>
	<td>Boys</td>
	<td>Girls</td>
	<td>Boys</td>
	<td>Girls</td>
	<td>Boys</td>
	<td>Girls</td>	
	<td>Total</td>	
</tr>

<tr>
	<td>Total Age of Pupils</td>
	<td><?php echo $prep['sum_age_promoted_boys']; ?></td>
	<td><?php echo $prep['sum_age_promoted_girls']; ?></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['sum_age_promoted_boys']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['sum_age_promoted_girls']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['sum_age_promoted_boys']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['sum_age_promoted_girls']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['sum_age_promoted_total']; ?>" /></td>
</tr>

<tr>
	<td>Average Age of Pupils</td>
	<td><?php echo $prep['ave_age_promoted_boys']; ?></td>
	<td><?php echo $prep['ave_age_promoted_girls']; ?></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['ave_age_promoted_boys']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['ave_age_promoted_girls']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['ave_age_promoted_boys']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['ave_age_promoted_girls']; ?>" /></td>
	<td><input class="vc40" style="border:none;" value="<?php echo $prep['ave_age_promoted_total']; ?>" /></td>
</tr>


</table>

<!------------------------------------------------------------------------------------------------------------------------>

<p class="foothalf" >
Date: <input style="border:none;" class="vc150 center u" 
value="<?php echo '___'.date('F d, Y',strtotime($_SESSION['today'])).'___'; ?>" />
<br />
</p>


<p class="center foothalf" >
<input style="border:none;" class="vc300 center u" 
value="<?php echo '___'.$_SESSION['settings']['school_principal_hs'].'___'; ?>" />



<br /> 
Principal <br /> <br /> 
</p>

<p>
Approved: <br /> <br /> 
__________________________________ <br /> 
District Supervisor or Supervising Principal

</p>




</div>	<!--  #footleft -->

<!---------------------------------------------------------------------------->

<div id="footcenter" >
<p class="<?php echo $fontfoot; ?>" ><span class="b" >INSTRUCTIONS</span>
<br /><br />
1. This form accomplished in triplicate, should serve as permanent record of all promotion during ot at the end of the school year in Grades IV- VI inclusive 
<br /><br />
2. The copies of this form for the fourth Year should be fully accomplished a week before the end of the school year, and those for Grades IV and V at the close of the school year. The original copy should be retained in the office of the principal, the duplicate should be forwarded to the division office as soon as accomplished and approved, and the triplicate should be kept on file in the office of the district supervisor. 
<br /><br />
3. A separate report for each section of each grade of each curriculum is required 
<br /><br />
4. Names of boys should be written first, followed by names of girls listed separately. Pupils names should be written in the same order on all copies. The total number of pupils listed agree with the yearly enrolment reported omn MEC form 2 for March plus the number promoted from the grade to higher grade during the school year. Theses should be listed separately at the botton of the form. 
<br /><br />
5. Under "year in School" write 4,4 1/2,5,5 1/2 .6.61/2 etc. to indicate the exact length of time the pupil has been in school from the first time he entered any school to the date of accomplishing this form. 
<br />
<br />
6. The age of the pupil as recorded on this form should be his age as of the end of the school year as recorded in MEC Form 1 (School Register) 
<br /><br />
7. Opposite the name of each pupil who drops out during the year should be entered such brief explanation of the cause as "111," "Deceased," "Dropped January 12"etc. 
<br /><br />
8. Under "Total Number of Days in Grade " indicate total number of days the pupil has attended the grade in current and proceeding school years. 
<br /><br />
9. All final ratings on this form are to be indicated in percent. 
<br /><br />
10. The date for"Average "at the bottom of the sheet will be found by adding the entries in th column and dividing the total thus obtained by the number of pupils for whom final rating are entered. 
<br /><br />
11. The term "Final Rating "signifies either the average of the periodic rating in a subject according to the averaging system of grading.</pre>
</p>

</div>

<!---------------------------------------------------------------------------->

<div id="footright" >


<p class="<?php echo $fontfoot; ?>" >12. In indicating action taken on this form use only the word"promoted" 
<br />and the word "retained" and abbreviate them to "Prom" and Ret" <br />respectively. 
<br /> 
<br /> 
13. In Grade IV and in the intermediate grades, the general average of <br />each pupil shall be obtained by dividing the sum of the subject final ratings <br />by the number of subjects or combinations of subject entered under <br />item 16 following . Each subject or combination of subject will have a <br />weight of one. In these grades a minimum average of 75 percent is required <br />for promotion 
<br /> <br /> 
14. When the blanks under "Summary of Pupils Enrolled" are filled in, <br />the following points should be remembered: <br />the March monthly enrolment <br />given on first line should agree with the March monthly enrolment as it <br />appears on MEC Form 2. The data for the second line should include all <br />pupils promoted to the next higher grade during, not at the close of, the <br />school year. The data for the third line ae found by adding numbers given on <br />the first and second lines. 
<br /> <br /> 
15. The sum of ages or all pupils concerned should appear where"Total <br />Age of Pupils " is called for. 
<br /> <br /> 
16. In indicating the subject under the column "Final ating In" <br />arrange the subjects alphabetically. 
<br /> <br /> <br />
REFERENCES <br /> Circulars: Nos 24 and 34 , s 1928; 45,s 1930; 13 and 35,s. <br />1932; 23,s 1933;15 and 48,s 1932; 18,s 1936;46,s 1937;18 and 44, <br />s. 1938 <br /> Memoradums: Nos 29,s 1927; 28,s 1930; 36,s.1940 <br /> Department Memoradums; Nos. 3,6, and 16.s 1945 <br /> General Instructions: No. 13,1925. <br /> Service Manual : Secs. 09,102,111-112, and 115-116 <br /> </p>

</div>


<!---------------------------------------------------------------------------->

<div class="clear ht50" ></div>