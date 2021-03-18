


<div class="accordParent" >	
<button onclick="accorToggle('stud')" class="vc300 bg-blue2" > <p class="b f16" > <?php echo "Student"; ?> </p> </button>  	
<table id="stud" class="gis-table-bordered table-fx" >
<tr><th class="vc150" >Discountable</th><td class="vc300" >
<select id="discount" class="full" name="student[discount]" >
	<option value="1" <?php echo ($student["is_discountable"])? "selected" : null; ?> >Yes</option>
	<option value="0" <?php echo (!$student["is_discountable"])? "selected" : null; ?> >No</option>
</select>
</td></tr>
<tr><th class="vc150" >Years in School</th><td><input id="yis" class="full pdl05 yis" type="text" name="student[yis]" value="<?php echo $student['years_in_school']; ?>" ></td></tr>
<tr><th class="vc150" >Year Entry</th><td><input id="ye" class="full pdl05 ye" type="text" name="student[ye]" value="<?php echo $student['year_entry']; ?>" ></td></tr>
<tr><th class="vc150" >Level Entry</th><td><input id="le" class="full pdl05 le" type="text" name="student[le]" value="<?php echo $student['level_entry']; ?>" ></td></tr>
<tr><th class="vc150" >Batch</th><td><input id="batch" class="full pdl05 batch" type="text" name="student[batch]" 
	value="<?php echo $student['batch']; ?>" ></td></tr>

<tr><th class="vc150" >Incomplete Subjects</th><td><input id="incsubj" class="full pdl05 incsubj" type="text" name="student[incsubj]" 
	value="<?php echo $student['incsubj']; ?>" ></td></tr>



<tr><td colspan="2" >
	<button id="usbtn" onclick="updateStudent();return false;" >Update Student</button>
</td></tr>

</table>

</div>