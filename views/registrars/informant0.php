<script>
$(function(){
	// hd();
})
	
function selectTable(i){
	$("#tbl"+i).attr('checked',true);
}
	
	
</script>




<!--   ---------------------------------- DIV ----------------------------------    -->

<div class="hd"  > <!-- entire informant hd div -->

<!--   ---------------------------------- INFORMANT ----------------------------------    -->

<h5>  
	Informant | 
	<?php $controller = ($_SESSION['user']['role_id']==5)? 'mis':'registrars';  ?>
	<a href="<?php echo URL.$controller; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

<form method="POST" >

<table class="gis-table-bordered" >
<tr>
	<th>Contacts</th>
	<td> <input autofocus class="pdl05" type="text" name="data[tcid]" id="1" onclick="selectTable(this.id);return false;" placeholder="ID or Name" /> </td>
</tr>

<tr>
	<th>Classroom</th>
	<td> <input class="pdl05" type="text" name="data[crid]" id="2" onclick="selectTable(this.id);return false;" placeholder="crid"  /> </td>
</tr>
<tr>
	<th>Course</th>
	<td> <input class="pdl05" type="text" name="data[crsid]" id="3" onclick="selectTable(this.id);return false;" placeholder="course_id"  /> </td>
</tr>

</table>


<!--   ====================================== TBL SELECTOR ===================================================    -->

<br /><br /><table>
	<tr>
		<td colspan='2' class='vc200' >
			<input id='tbl1' type='radio' name='table' value='1' checked >Contacts<br />
			<input id='tbl2' type='radio' name='table' value='2' >Classroom<br />
			<input id='tbl3' type='radio' name='table' value='3' >Course<br />
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
