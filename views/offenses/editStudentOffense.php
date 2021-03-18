<?php 
// pr($_SESSION['q']);
?>

<h5>Edit Student Offense
| <?php $this->shovel('homelinks'); ?>

</h5>


<form method="POST" >

<table class="gis-table-bordered" >
<tr><th>Scid</th><td><?php echo $row['scid']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['name']; ?></td></tr>
<tr><th colspan=2 class="center" >Quarter 1</th></tr>
<tr><th>Q1 Minor</th><td><input type="number" class="vc100" name="q1_minor" value="<?php echo $row['q1_minor']; ?>" /></td></tr>
<tr><th>Q1 Major A</th><td><input type="number" class="vc100" name="q1_major_a" value="<?php echo $row['q1_major_a']; ?>" /></td></tr>
<tr><th>Q1 Major B</th><td><input type="number" class="vc100" name="q1_major_b" value="<?php echo $row['q1_major_b']; ?>" /></td></tr>
<tr><th colspan=2 class="center" >Quarter 2</th></tr>
<tr><th>Q2 Minor</th><td><input type="number" class="vc100" name="q2_minor" value="<?php echo $row['q2_minor']; ?>" /></td></tr>
<tr><th>Q2 Major A</th><td><input type="number" class="vc100" name="q2_major_a" value="<?php echo $row['q2_major_a']; ?>" /></td></tr>
<tr><th>Q2 Major B</th><td><input type="number" class="vc100" name="q2_major_b" value="<?php echo $row['q2_major_b']; ?>" /></td></tr>
<tr><th colspan=2 class="center" >Quarter 3</th></tr>
<tr><th>Q3 Minor</th><td><input type="number" class="vc100" name="q3_minor" value="<?php echo $row['q3_minor']; ?>" /></td></tr>
<tr><th>Q3 Major A</th><td><input type="number" class="vc100" name="q3_major_a" value="<?php echo $row['q3_major_a']; ?>" /></td></tr>
<tr><th>Q3 Major B</th><td><input type="number" class="vc100" name="q3_major_b" value="<?php echo $row['q3_major_b']; ?>" /></td></tr>
<tr><th colspan=2 class="center" >Quarter 4</th></tr>
<tr><th>Q4 Minor</th><td><input type="number" class="vc100" name="q4_minor" value="<?php echo $row['q4_minor']; ?>" /></td></tr>
<tr><th>Q4 Major A</th><td><input type="number" class="vc100" name="q4_major_a" value="<?php echo $row['q4_major_a']; ?>" /></td></tr>
<tr><th>Q4 Major B</th><td><input type="number" class="vc100" name="q4_major_b" value="<?php echo $row['q4_major_b']; ?>" /></td></tr>


<tr><td colspan=2><input type="submit" name="submit" value="Submit"  ></td></tr>

</table>
</form>
