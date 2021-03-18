<?php 

// pr($info['profile'][0]);

?>

<script>
$(function(){
	hd();
	columnHighlighting();	

})
	
function selectTable(i){
	$("#tbl"+i).attr('checked',true);
}
	
	
</script>






<!--   ---------------------------------- INFORMANT ----------------------------------    -->

<h5>  
	Informant
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

<form method="POST" >

<table class="gis-table-bordered" >
<tr>
	<th>Contacts</th>
	<td> <input autofocus class="pdl05" type="text" name="data[tcid]" id="1" onclick="selectTable(this.id);return false;" placeholder="ID or Name" /> </td>
	<td><input type="submit" name="submit" value="Inform"   ></td>
</tr>


</table>



<!--   ====================================== SUBMIT ===================================================    -->

</form>

<!--   ====================================== DATA INFO ===================================================    -->

<br /><hr />
<h4>Info</h4>


<?php if(isset($info)): ?>
<form method="POST" >	

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>UC</th>
	<th>PC</th>
	<th>Code</th>
	<th>Account</th>
	<th>Pass</th>
	<th>M/F</th>
	<th>Name</th>
	<th>Actv</th>
	<th>Clrd</th>
	<th>T</th>
	<th>R</th>
	<th>P</th>
	<th>Birthdate</th>
	<th>SMS</th>
	<th>Email</th>
</tr>

<?php $i=0; ?>
<?php foreach($info['profile'] AS $row): ?>
<?php $i++; ?>
<tr>
	<td class="colshading" ><?php echo $i; ?></td>
	<td class="colshading" ><?php echo $row['ucid']; ?></td>
	<td class="colshading" ><?php echo $row['pcid']; ?></td>
	<td class="colshading" ><?php echo $row['code']; ?></td>
	<td class="colshading" ><?php echo $row['account']; ?></td>
	<td class="colshading" ><?php echo $row['ctp']; ?></td>
	<td class="colshading" ><?php echo ($row['is_male']==1)?'Y':'-'; ?></td>
	<td class="colshading" ><?php echo $row['contact']; ?></td>
	<td class="colshading" ><?php echo ($row['is_active']==1)?'Y':'-'; ?></td>
	<td class="colshading" ><?php echo ($row['is_cleared']==1)?'Y':'-'; ?></td>
	<td class="colshading" ><?php echo $row['title_id']; ?></td>
	<td class="colshading" ><?php echo $row['role_id']; ?></td>
	<td class="colshading" ><?php echo $row['privilege_id']; ?></td>
	<td class="colshading" ><?php echo $row['birthdate']; ?></td>
	<td class="colshading" ><?php echo $row['sms']; ?></td>
	<td class="colshading" ><?php echo $row['email']; ?></td>
	<td class="colshading" ><a href='<?php echo URL."contacts/ucis/".$row['ucid']; ?>' >UCIS</a></td>
</tr>
<?php endforeach; ?>

</table>


<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p class="hd" > <input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Save"   /> </p>

</form>


<?php endif; ?>





