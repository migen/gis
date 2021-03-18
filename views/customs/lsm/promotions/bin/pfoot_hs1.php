

<?php 

$spacing = 12;
$numliner = 3;
$fontfoot = "f12 tf12";
$fontfooter = "tf14";
$bordercolor = "white";

// pr($prep);

?>


<style>


#footleft{
	width:26%;
	float:left;
	padding-top:30px;
	text-align:left;
	padding-left:10px; 
	border:1px solid <?php echo $bordercolor; ?>;
	margin:0;

}

#footcenter{
	width:38%;
	float:left;
	margin:0;
	padding: 0 12px;
	border:1px solid <?php echo $bordercolor; ?>;	
}



#footright{
	width:26%;
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

<div id="pfoot" >

<!-------------------------------------------------------------------------------------->

<div id="footleft" class="<?php echo $fontfoot; ?> f10" >

<p style="text-align: center;">
<span class="f20 b" >DepED</span> 
Form 18-E-1 </p>


<hr />
<hr class="triple" style="" />


<p style="text-align: center;"><br />
<span class="f22 b" >REPORT ON PROMOTION</span>
&nbsp;<br />
(GRADES I-III INCLUSIVE)&nbsp;</p>
<p>

<table class="left" >

<tr><th>Division<?php liner($numliner); ?></th>
<td><input style="border:none;" class="vc150 " 
	value="<?php echo $_SESSION['settings']['school_division']; ?>" />
</td></tr>

<tr><th>Municipality<?php liner($numliner); ?></th>
<td><input style="border:none;" class="vc150  " 
	value="<?php echo $_SESSION['settings']['school_city']; ?>" />
</td></tr>

<tr><th>School<?php liner($numliner); ?></th>
<td><input style="border:none;" class="vc250  " 
	value="<?php echo $_SESSION['settings']['school_name']; ?>" />
</td></tr>

<tr><th>Grade<?php liner($numliner); ?></th>
<td><input style="border:none;" class="vc150  " 
	value="<?php echo $classroom['level']; ?>" />
</td></tr>

<tr><th>Year ending<?php liner($numliner); ?></th>
<td><input style="border:none;" class="vc150  " 
	value="<?php echo $_SESSION['settings']['school_closed']; ?>" />
</td></tr>

<tr><th>Date submitted<?php liner($numliner); ?></th>
<td><input style="border:none;" class="vc150  " 
	value="<?php echo $_SESSION['today']; ?>" />
</td></tr>

<tr><th>Teachers<?php liner($numliner); ?></th>
<td><input style="border:none;" class="vc300  " 
	value="<?php echo $classroom['adviser']; ?>" />
</td></tr>


</table>

</p>

<?php 

echo "<hr class='pct90' />";
liner($numliner); 
echo "<hr class='pct90' />";

?>


<!------------------------------------------------------------------------------------------------------------------------>


<!------------------------------------------------------------------------------------------------------------------------>


<p><table class="" >
<tr><th class="vc100" >Date<?php liner(0); ?></th>
<td><input style="border:none;" class="vc150 " 
	value="<?php echo $_SESSION['today']; ?>" />
</td></tr>
</table></p>

<div class="center" >
<hr class="double pct60" >
<input style="border:none;" class="vc300 b center" 
	value="<?php echo strtoupper($_SESSION['settings']['school_principal_gs']); ?>" />
<hr class="double pct60" >


</div>


<p>
<span class="b" >APPROVED: </span> <br /> <br /> 
__________________________________ <br /> 
District Supervisor or Supervising Principal

</p>




</div>	<!--  #footleft -->

<!---------------------------------------------------------------------------->

<div id="footcenter" >

<div class="pct90 " >
<p class="" >


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

<table class="gis-table-bordered" style="" >

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
</p>	

<p class="f12 pct80" ><?php spacer(4); ?>NOTE: The person making this report shall also fill in the blank spaces under "Report Provisions" on this side of the form. </p>


</div>	<!-- tables -->

<p class="pct70 <?php echo $fontfoot; ?>" >

<span class="b" >INSTRUCTIONS</span><br /><br />

<?php spacer(6); ?> 
1. This form will be made out in duplicate at the close of the school year by each teacher who is in charge of the enrollment and attendance records of any class in Grades I,II,or III. The original copy should be retained on file in the office of the principal of the school and the duplicate sent to the division office for filing.&nbsp;
<br /> 
<?php spacer(6); ?> 
2. In the column will be written the names of all pupils eho have been <br /> enrolled during the year in theboys first, register of the class for which the report is made . List names of boys first. <br /> 
<?php spacer(6); ?> 
3. Under "Years in school "write 1.1 1/2 2. 2 1/2. 3. 3 1/2 etc. to indicate the exact length of time the pupil has in school from the first  time he entered any school to the date of accomplishing this form. <br /> 
<?php spacer(6); ?> 
4. The age the pupil as reported on this should be his age as of March . <br /> To find his age as April 1, add to his age as of the beginning of the school year, recorded in MEC form 1-School Register. <br /> 
<?php spacer(6); ?> 
5, Under "Home Address " should be written the actual residence of the pupil, not a temporary residence which he may have taken up while attending school <br /> 
<?php spacer(6); ?>
6. A pupil who is promoted during the year will be reported in each grade which be is enrolled. <br /> 
<?php spacer(6); ?>
7. In the column for "Final Rating" should be indicated the final rating received by the pupil during the month he was enrolled in. The grade for which the report is made. For example, if a pupil is enrolled in Grade I in July and is promoted to Grade II in September he should be reported in MEC Form 18-E-1 both for Grade I and Grade II will be based upon his work from October to March, and not on those month in which he is studying in Grade I. This Term "Final rating" signifies either the average of all periodic rating according to the cumulative to the averaging system of grading or the last periodic grading, after the first is obtained by dividing by 3 the sum of twice the tentative rating anf the periodic rating immediately proceeding and the and the periodic rating becomes the final rating. <br /> 
<?php spacer(6); ?>
8. Great care should be exerted to make sure that the total number of days the <br />pupil attended the grade in both present and past school year is correctly recorded.

</p>



</div>

<!---------------------------------------------------------------------------->

<div id="footright" >


<p class="pct90 <?php echo $fontfoot; ?>" >
<?php spacer(6); ?>
9, Under "Remarks" indicated all pupils promoted during the school year to the grade for which the report is made, by writing the words. "Promoted from Grade giving number of the grade and the date on which the promotion was made. Indicate all Grade I pupils who enter the grade for the first time during the school year by writing the word "Entered School, giving the date on which the pupil entered. <br /> 
<?php spacer(6); ?>
10. When the blanks under "Summary of Pupils Enrolled" are filled in, the following points should be borne in mind. 
	<br /> <?php spacer(8); ?> 
(1) The March monthly-enrollment figure given on the first should agree with the monthly-enrollment figures given on MEC form 2 for March. 
	<br /> <?php spacer(8); ?> 
(2) The data for the second line should include all pupils promoted to the next higher grade before end of the school year. 
	<br /> <?php spacer(8); ?> 
(3 ) The date for the third line may found by adding the figures on the first line to the figures on the second line. 
<br /> 
<?php spacer(6); ?>
11. Data for the "Summary of Pupils Promoted" may be obtained from the face of the form. <br /> 
<?php spacer(6); ?>
12. The sum of the ages of all pupils concerned should appear where "Total Age of Pupils is called for 
<br /> For example : Total age in class of 40 Pupils is 380 <br /> Average age 380-40=9.5. <br /> 
<?php spacer(6); ?>
13. In indicating action taken on this form use only the word "promoted" and the word "retained" and abbreviate them to Prom., and Ret., respectively. 
<br /> <br /> <br /> References <br /> Circular : Nos 50,s 1928;45,s 1930;s, 1932; <br /> 23, s 1938; 48 s. 1940 <br /> Memoramdum; No 36,s 1940 <br /> General Instructions; No.13,s 1925 <br /> Service Manual; 99-100-101;112-113 <br />
</p>

</div>


<!-------------------------------------------------------------------------------------->
</div>	<!-- pfoot -->



<div class="clear ht50" ></div>