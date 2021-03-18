<script>
$(function(){
	hd();
})
	
function selectTable(i){
	$("#tbl"+i).attr('checked',true);
}
	
	
</script>


<?php 
// pr($data);
?>


<h2>Home</h2>

<!-- ========================  page info / user info =================================-->
<table class='gis-table-bordered table-fx'>
<tr class="hd" ><th class="bg-blue2" >CID</th><td><?php echo $user['user_id']; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >DID</th><td><?php echo $user['department_id']; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >ACL</th><td><?php echo $user['role_id'].'-'.$user['privilege_id']; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >Title</th><td><?php echo $user['title_id'].'-'.$user['title']; ?></td></tr>
<tr><th class="bg-blue2" >ID Number</th><td><?php echo $user['code']; ?></td></tr>
<tr><th class="bg-blue2" >Teacher</th><td><?php echo $_SESSION['user']['fullname']; ?></td></tr>
<tr><th class="bg-blue2" >School year</th><td><?php echo $_SESSION['sy'].' - '; echo ((int)$_SESSION['sy']+1); ?></td></tr>

</table><br /><br />


<!--  ================= INDEX ==========================================	 -->

<table class="gis-table-bordered table-fx ">
<tr class='bg-blue2'>
	<th class="vc50" >#</th>
	<th class="vc200" >Level</th>
</tr>

<?php $i=1; ?>
<?php foreach($data['levels'] AS $row): ?>
<tr>
	<td><?php echo $i; ?></td>
	<td>
		<a href="<?php echo URL.'registrars/level/'.$row['id']; ?>"><?php echo $row['name']; ?></a>
	</td>
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>

<br />

<h4><a href="<?php echo URL.'registrars/statuses'; ?>" > Drop Students</a></h4>




<!--   ========================================= DIV ==================================================    -->

<div class="hd"  > <!-- entire informant hd div -->



<!--   ========================================= INFORMANT ==================================================    -->

<div class="ht500" > </div>

<h4> INFORMANT </h4>
<form method="POST" >

<table class="gis-table-bordered" >
<tr>
	<th>Teacher</th>
	<td> <input class="pdl05" type="text" name="data[tcid]" id="1" onclick="selectTable(this.id);return false;" placeholder="teacher_id" /> </td>
</tr>
<tr>
	<th>Student</th>
	<td> <input class="pdl05" type="text" name="data[scid]" id="2" onclick="selectTable(this.id);return false;" placeholder="student_id"  /> </td>
</tr>
<tr>
	<th>Classroom</th>
	<td> <input class="pdl05" type="text" name="data[crid]" id="3" onclick="selectTable(this.id);return false;" placeholder="crid"  /> </td>
</tr>
<tr>
	<th>Course</th>
	<td> <input class="pdl05" type="text" name="data[crsid]" id="4" onclick="selectTable(this.id);return false;" placeholder="course_id"  /> </td>
</tr>

</table>


<!--   ====================================== TBL SELECTOR ===================================================    -->

<br /><br /><table>
	<tr>
		<td colspan='2' class='vc200' >
			<input id='tbl1' type='radio' name='table' value='1' >Teacher<br />
			<input id='tbl2' type='radio' name='table' value='2' checked >Student<br />
			<input id='tbl3' type='radio' name='table' value='3' >Classroom<br />
			<input id='tbl4' type='radio' name='table' value='4' >Course<br />
		</td>
	</tr>
</table>

<!--   ====================================== SUBMIT ===================================================    -->
<br /><input type="submit" name="submit" value="Inform"   >
</form>

<!--   ====================================== DATA INFO ===================================================    -->

<br /><hr />
<h4>Info</h4>
<?php 
	if(isset($data['info'])){
		pr($data['info']);	
	}
	
?>




<!--   =========================================================================================================    -->


</div> <!-- end of informant hd div -->
 
